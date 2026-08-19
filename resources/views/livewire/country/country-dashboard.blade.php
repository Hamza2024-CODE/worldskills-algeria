<div class="space-y-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Header & Action Controls -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950 text-[#0066FF] dark:text-sky-400 flex items-center justify-center font-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21a2 2 0 012 2v11a2 2 0 01-2 2H12l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-black text-[#06205C] dark:text-white tracking-tight">
                    {{ $country?->getLocalized('name') ?? (app()->getLocale() === 'fr' ? 'Délégation Nationale' : (app()->getLocale() === 'en' ? 'National Delegation' : 'الوفد الوطني')) }} — {{ app()->getLocale() === 'fr' ? 'Centre de la Délégation Officielle' : (app()->getLocale() === 'en' ? 'Official Delegation Center' : 'مركز إدارة ومتابعة الوفد الرسمي') }}
                </h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5">
                    {{ app()->getLocale() === 'fr' ? 'Gestion complète: juges, presse, encadrants, VIP, recours techniques et carte du village.' : (app()->getLocale() === 'en' ? 'Complete management: judges, press, supervisors, VIPs, technical appeals & venue maps.' : 'إدارة شاملة لجميع فئات الوفد: الحكام، الصحافيون، المؤطرون، الشخصيات المرموقة، الطعون الفنية والخرائط.') }}
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button wire:click="openAddModal" class="px-4 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Ajouter Membre (Juge / Presse / Encadrant)' : (app()->getLocale() === 'en' ? 'Add Member (Judge / Press / Supervisor)' : 'إضافة عضو (حكم / صحفي / مؤطر / VIP)') }}</span>
            </button>
            <button wire:click="$set('showAppealModal', true)" class="px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Déposer un Recours Technique' : (app()->getLocale() === 'en' ? 'Submit Technical Appeal' : 'تقديم طعن فني') }}</span>
            </button>
            <a href="{{ route('country.dietary') }}" class="px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                <span>🥗</span>
                <span>{{ app()->getLocale() === 'fr' ? 'Allergies & Restauration' : (app()->getLocale() === 'en' ? 'Dietary & Allergies' : 'حساسية الطعام والإطعام') }}</span>
            </a>
            <a href="{{ route('country.skills') }}" class="px-4 py-2.5 rounded-xl bg-slate-900 dark:bg-slate-700 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Sélection Métiers' : (app()->getLocale() === 'en' ? 'Select Trades' : 'تحديد المهن') }}</span>
            </a>
        </div>
    </div>

    <!-- Flash Notification -->
    @if($flashMessage ?? null)
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-xs font-bold flex items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ $flashMessage }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="text-emerald-600 dark:text-emerald-400 font-bold text-xs">✕</button>
        </div>
    @endif

    <!-- Operational Role KPI Grid (7 Cards) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3">
        <!-- Total Delegation -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs text-center">
            <span class="text-slate-400 dark:text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Total Délégation' : (app()->getLocale() === 'en' ? 'Total Delegation' : 'إجمالي الوفد') }}</span>
            <p class="text-2xl font-black text-[#06205C] dark:text-white mt-1">{{ $totalDelegationMembers ?? 0 }}</p>
            <span class="text-[9px] font-bold text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950 px-2 py-0.5 rounded-full inline-block mt-1">{{ app()->getLocale() === 'fr' ? 'Accrédité' : (app()->getLocale() === 'en' ? 'Accredited' : 'وفد موثق') }}</span>
        </div>

        <!-- Competitors -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs text-center">
            <span class="text-slate-400 dark:text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Compétiteurs' : (app()->getLocale() === 'en' ? 'Competitors' : 'المتنافسون') }}</span>
            <p class="text-2xl font-black text-blue-600 dark:text-sky-400 mt-1">{{ $participantsCount ?? 0 }}</p>
            <span class="text-[9px] font-bold text-blue-600 dark:text-sky-300 bg-blue-50 dark:bg-blue-950 px-2 py-0.5 rounded-full inline-block mt-1">{{ app()->getLocale() === 'fr' ? 'Candidats' : (app()->getLocale() === 'en' ? 'Candidates' : 'مترشحون') }}</span>
        </div>

        <!-- Judges -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs text-center">
            <span class="text-slate-400 dark:text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Juges Officiels' : (app()->getLocale() === 'en' ? 'Official Judges' : 'عدد الحكام') }}</span>
            <p class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1">{{ $judgesCount ?? 0 }}</p>
            <span class="text-[9px] font-bold text-amber-600 dark:text-amber-300 bg-amber-50 dark:bg-amber-950 px-2 py-0.5 rounded-full inline-block mt-1">{{ app()->getLocale() === 'fr' ? 'Jury Techn.' : (app()->getLocale() === 'en' ? 'Tech Jury' : 'حكام معتمدون') }}</span>
        </div>

        <!-- Press / Media -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs text-center">
            <span class="text-slate-400 dark:text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Presse & Médias' : (app()->getLocale() === 'en' ? 'Press & Media' : 'الصحافيون والإعلام') }}</span>
            <p class="text-2xl font-black text-cyan-600 dark:text-cyan-400 mt-1">{{ $pressCount ?? 0 }}</p>
            <span class="text-[9px] font-bold text-cyan-600 dark:text-cyan-300 bg-cyan-50 dark:bg-cyan-950 px-2 py-0.5 rounded-full inline-block mt-1">{{ app()->getLocale() === 'fr' ? 'Médias' : (app()->getLocale() === 'en' ? 'Media' : 'تغطية إعلامية') }}</span>
        </div>

        <!-- Supervisors -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs text-center">
            <span class="text-slate-400 dark:text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Encadrants & Chefs' : (app()->getLocale() === 'en' ? 'Supervisors & Leaders' : 'المؤطرون والقادة') }}</span>
            <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">{{ $supervisorsCount ?? 0 }}</p>
            <span class="text-[9px] font-bold text-indigo-600 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-950 px-2 py-0.5 rounded-full inline-block mt-1">{{ app()->getLocale() === 'fr' ? 'Supervision' : (app()->getLocale() === 'en' ? 'Supervision' : 'تأطير ميداني') }}</span>
        </div>

        <!-- VIP & Officials -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs text-center">
            <span class="text-slate-400 dark:text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Membres VIP & Officiels' : (app()->getLocale() === 'en' ? 'VIPs & Officials' : 'شخصيات VIP') }}</span>
            <p class="text-2xl font-black text-rose-600 dark:text-rose-400 mt-1">{{ $vipCount ?? 0 }}</p>
            <span class="text-[9px] font-bold text-rose-600 dark:text-rose-300 bg-rose-50 dark:bg-rose-950 px-2 py-0.5 rounded-full inline-block mt-1">{{ app()->getLocale() === 'fr' ? 'Délégation VIP' : (app()->getLocale() === 'en' ? 'VIP Roster' : 'وفد شرفي') }}</span>
        </div>

        <!-- Selected Skills -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-xs text-center">
            <span class="text-slate-400 dark:text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Métiers Sélectionnés' : (app()->getLocale() === 'en' ? 'Selected Trades' : 'المهن المعتمدة') }}</span>
            <p class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1">{{ $selectedSkillsCount ?? 0 }}</p>
            <span class="text-[9px] font-bold text-purple-600 dark:text-purple-300 bg-purple-50 dark:bg-purple-950 px-2 py-0.5 rounded-full inline-block mt-1">{{ app()->getLocale() === 'fr' ? 'Disciplines' : (app()->getLocale() === 'en' ? 'Disciplines' : 'تخصصات') }}</span>
        </div>
    </div>

    <!-- Navigation Tabs (Roster | Appeals | Venue Map | Regulations) -->
    <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-2">
        <button wire:click="$set('activeTab', 'roster')" class="px-5 py-2.5 rounded-2xl font-black text-xs transition border-b-2 flex items-center gap-2 {{ ($activeTab ?? 'roster') === 'roster' ? 'bg-white dark:bg-slate-800 text-[#0066FF] dark:text-sky-400 border-[#0066FF] dark:border-sky-400 shadow-xs' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border-transparent' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Membres & Approbation' : (app()->getLocale() === 'en' ? 'Delegation Members & Approval' : 'أعضاء الوفد والموافقة') }}</span>
        </button>

        <button wire:click="$set('activeTab', 'appeals')" class="px-5 py-2.5 rounded-2xl font-black text-xs transition border-b-2 flex items-center gap-2 {{ ($activeTab ?? 'roster') === 'appeals' ? 'bg-white dark:bg-slate-800 text-purple-600 dark:text-purple-400 border-purple-600 dark:border-purple-400 shadow-xs' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border-transparent' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Suivi des Recours Techniques (' . ($appeals->count() ?? 0) . ')' : (app()->getLocale() === 'en' ? 'Technical Appeals Tracking (' . ($appeals->count() ?? 0) . ')' : 'متابعة الطعون والتظلمات الفنية (' . ($appeals->count() ?? 0) . ')') }}</span>
        </button>

        <button wire:click="$set('activeTab', 'rules')" class="px-5 py-2.5 rounded-2xl font-black text-xs transition border-b-2 flex items-center gap-2 {{ ($activeTab ?? 'roster') === 'rules' ? 'bg-white dark:bg-slate-800 text-amber-600 dark:text-amber-400 border-amber-600 dark:border-amber-400 shadow-xs' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border-transparent' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Règlements & Conditions' : (app()->getLocale() === 'en' ? 'Rules & Regulations' : 'الشروط واللوائح القانونية') }}</span>
        </button>
    </div>

    <!-- TAB 1: ROSTER & MEMBERS MANAGEMENT -->
    @if(($activeTab ?? 'roster') === 'roster')
        <div class="space-y-4">
            <!-- Search & Filter Controls -->
            <div class="bg-white dark:bg-slate-800 p-4 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="relative w-full sm:w-80">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ app()->getLocale() === 'fr' ? 'Rechercher nom, passeport ou NIN...' : (app()->getLocale() === 'en' ? 'Search by name, passport or NIN...' : 'ابحث باسم العضو، الجواز أو NIN...') }}" class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-[#06205C] dark:text-white">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <select wire:model.live="filterRole" class="px-3 py-2 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-[#06205C] dark:text-white">
                        <option value="ALL">{{ app()->getLocale() === 'fr' ? 'Toutes les catégories' : (app()->getLocale() === 'en' ? 'All Roles' : 'كل الفئات والأدوار') }}</option>
                        <option value="PARTICIPANT">PARTICIPANT — {{ app()->getLocale() === 'fr' ? 'Compétiteurs' : (app()->getLocale() === 'en' ? 'Competitors' : 'المتنافسون') }}</option>
                        <option value="JUDGE">JUDGE — {{ app()->getLocale() === 'fr' ? 'Juges Officiels' : (app()->getLocale() === 'en' ? 'Official Judges' : 'الحكام') }}</option>
                        <option value="PRESS">PRESS — {{ app()->getLocale() === 'fr' ? 'Presse & Médias' : (app()->getLocale() === 'en' ? 'Press & Media' : 'الصحافيون والإعلام') }}</option>
                        <option value="SUPERVISOR">SUPERVISOR — {{ app()->getLocale() === 'fr' ? 'Encadrants' : (app()->getLocale() === 'en' ? 'Supervisors' : 'المؤطرون والقادة') }}</option>
                        <option value="VIP">VIP — {{ app()->getLocale() === 'fr' ? 'Délégation VIP' : (app()->getLocale() === 'en' ? 'VIP Officials' : 'شخصيات VIP') }}</option>
                        <option value="EXPERT">EXPERT — {{ app()->getLocale() === 'fr' ? 'Experts Technique' : (app()->getLocale() === 'en' ? 'Technical Experts' : 'الخبراء') }}</option>
                        <option value="OFFICIAL">OFFICIAL — {{ app()->getLocale() === 'fr' ? 'Officiels' : (app()->getLocale() === 'en' ? 'Officials' : 'المسؤولون الرسميون') }}</option>
                        <option value="SUPPORT_STAFF">SUPPORT_STAFF — {{ app()->getLocale() === 'fr' ? 'Equipe Support' : (app()->getLocale() === 'en' ? 'Support Staff' : 'طواقم الدعم') }}</option>
                    </select>

                    <select wire:model.live="filterStatus" class="px-3 py-2 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#06205C]">
                        <option value="ALL">{{ app()->getLocale() === 'fr' ? 'Tous les statuts' : (app()->getLocale() === 'en' ? 'All Statuses' : 'كل حالات الاعتماد') }}</option>
                        <option value="APPROVED">Approved — {{ app()->getLocale() === 'fr' ? 'Approuvé' : (app()->getLocale() === 'en' ? 'Approved' : 'معتمد وموافق عليه') }}</option>
                        <option value="PENDING">Pending — {{ app()->getLocale() === 'fr' ? 'En Attente' : (app()->getLocale() === 'en' ? 'Pending' : 'قيد التثبت') }}</option>
                        <option value="REJECTED">Rejected — {{ app()->getLocale() === 'fr' ? 'Rejeté' : (app()->getLocale() === 'en' ? 'Rejected' : 'مرفوض') }}</option>
                    </select>
                </div>
            </div>

            <!-- Roster Table -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-[#06205C] font-black border-b border-slate-200">
                                <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-6 py-4">{{ app()->getLocale() === 'fr' ? 'Nom & Prénom' : (app()->getLocale() === 'en' ? 'Full Name' : 'الاسم واللقب / العضو') }}</th>
                                <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-4 py-4">{{ app()->getLocale() === 'fr' ? 'Catégorie' : (app()->getLocale() === 'en' ? 'Role / Category' : 'الصفة / الفئة') }}</th>
                                <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-4 py-4">{{ app()->getLocale() === 'fr' ? 'Discipline / Métier' : (app()->getLocale() === 'en' ? 'Assigned Skill' : 'المهنة التنافسية') }}</th>
                                <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-4 py-4">{{ app()->getLocale() === 'fr' ? 'Document d\'Identité' : (app()->getLocale() === 'en' ? 'Identity Document' : 'وثيقة الهوية (NIN / الجواز)') }}</th>
                                <th class="text-center px-4 py-4">{{ app()->getLocale() === 'fr' ? 'Statut Approbation' : (app()->getLocale() === 'en' ? 'Approval Status' : 'حالة الموافقة') }}</th>
                                <th class="text-center px-6 py-4">{{ app()->getLocale() === 'fr' ? 'Actions' : (app()->getLocale() === 'en' ? 'Actions' : 'إجراءات التحكم') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($members as $m)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#0066FF] font-black flex items-center justify-center text-xs shrink-0 border border-blue-100">
                                                {{ mb_substr($m->first_name, 0, 1) }}{{ mb_substr($m->last_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-900 text-xs">{{ $m->full_name }}</p>
                                                <p class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $m->email ?: ($m->phone ?: '—') }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4">
                                        <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider {{ match($m->member_type) {
                                            'PARTICIPANT' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                            'JUDGE' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                            'PRESS' => 'bg-cyan-50 text-cyan-700 border border-cyan-200',
                                            'SUPERVISOR' => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
                                            'VIP' => 'bg-rose-50 text-rose-700 border border-rose-200',
                                            'EXPERT' => 'bg-purple-50 text-purple-700 border border-purple-200',
                                            default => 'bg-slate-100 text-slate-700 border border-slate-200'
                                        } }}">
                                            {{ $m->member_type }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 font-semibold text-slate-600">
                                        {{ $m->skill ? $m->skill->code . ' - ' . $m->skill->getLocalized('name') : '—' }}
                                    </td>

                                    <td class="px-4 py-4 font-mono font-bold text-slate-700">
                                        {{ $m->passport_number ? 'PASS-'.$m->passport_number : ($m->nin_number ? 'NIN-'.$m->nin_number : 'Valid') }}
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-black {{ $m->status === 'APPROVED' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($m->status === 'REJECTED' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-amber-50 text-amber-700 border border-amber-200') }}">
                                            {{ $m->status === 'APPROVED' ? (app()->getLocale() === 'fr' ? 'Approuvé' : (app()->getLocale() === 'en' ? 'Approved' : 'موافق عليه ومحجوز')) : ($m->status === 'REJECTED' ? (app()->getLocale() === 'fr' ? 'Rejeté' : (app()->getLocale() === 'en' ? 'Rejected' : 'مرفوض')) : (app()->getLocale() === 'fr' ? 'En cours' : (app()->getLocale() === 'en' ? 'Pending' : 'قيد التثبت'))) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button wire:click="viewMemberDetails({{ $m->id }})" title="Voir Dossier" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>

                                            @if($m->status !== 'APPROVED')
                                                <button wire:click="approveMember({{ $m->id }})" title="Approuver" class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            @endif

                                            @if($m->status !== 'REJECTED')
                                                <button wire:click="rejectMember({{ $m->id }})" title="Rejeter" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            @endif

                                            <button wire:click="editMember({{ $m->id }})" title="Editer" class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>

                                            <button wire:click="removeMember({{ $m->id }})" wire:confirm="Supprimer membre?" title="Supprimer" class="p-1.5 rounded-lg bg-slate-100 hover:bg-rose-100 hover:text-rose-700 text-slate-500 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-xs font-bold text-slate-400">
                                        {{ app()->getLocale() === 'fr' ? 'Aucun membre correspondant trouvé.' : (app()->getLocale() === 'en' ? 'No matching members found.' : 'لم يتم تسجيل أعضاء في الوفد الوطني مطابقة لخيارات البحث أو التصفية.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 2: TECHNICAL APPEALS & STAGE TRACKER -->
    @if(($activeTab ?? 'roster') === 'appeals')
        <div class="space-y-6">
            <div class="flex items-center justify-between bg-white p-5 rounded-3xl border border-slate-200">
                <div>
                    <h3 class="text-base font-black text-[#06205C]">{{ app()->getLocale() === 'fr' ? 'Suivi des Recours Techniques' : (app()->getLocale() === 'en' ? 'Technical Appeals Tracking' : 'متابعة الطعون والتظلمات الفنية المرفوعة') }}</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">{{ app()->getLocale() === 'fr' ? 'Suivi étape par étape de l\'examen des recours par le Jury.' : (app()->getLocale() === 'en' ? 'Step-by-step tracking of appeal reviews by the Jury.' : 'متابعة دقيقة لمراحل دراسة الطعن من لحظة الإيداع حتى صدور قرار هيئة التحكيم') }}</p>
                </div>
                <button wire:click="$set('showAppealModal', true)" class="px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md transition">
                    + {{ app()->getLocale() === 'fr' ? 'Nouveau Recours' : (app()->getLocale() === 'en' ? 'New Appeal' : 'إيداع طعن فني جديد') }}
                </button>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @forelse($appeals as $app)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-xl bg-purple-50 text-purple-700 font-mono font-black text-xs border border-purple-200">
                                    {{ $app->appeal_uuid }}
                                </span>
                                <h4 class="text-sm font-black text-[#06205C]">{{ $app->subject }}</h4>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ match($app->priority) {
                                    'HIGH' => 'bg-rose-50 text-rose-700 border border-rose-200',
                                    'URGENT' => 'bg-rose-600 text-white',
                                    default => 'bg-slate-100 text-slate-700 border border-slate-200'
                                } }}">
                                    Priority: {{ $app->priority }}
                                </span>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ match($app->status) {
                                    'APPROVED' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                    'REJECTED' => 'bg-rose-50 text-rose-700 border border-rose-200',
                                    'INVESTIGATING' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    default => 'bg-blue-50 text-blue-700 border border-blue-200'
                                } }}">
                                    Status: {{ $app->status }}
                                </span>
                            </div>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            {{ $app->description }}
                        </p>

                        <!-- STAGE TRACKER STEPPER -->
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">{{ app()->getLocale() === 'fr' ? 'Étapes du Recours (Stage Tracker)' : (app()->getLocale() === 'en' ? 'Appeal Stage Tracker' : 'مراحل دراسة الطعن (Stage Tracker)') }}</p>
                            <div class="grid grid-cols-4 gap-2 text-center text-xs">
                                <div class="p-2 rounded-xl {{ in_array($app->status, ['SUBMITTED', 'UNDER_REVIEW', 'INVESTIGATING', 'APPROVED', 'REJECTED']) ? 'bg-blue-50 text-blue-700 border border-blue-200 font-bold' : 'text-slate-400' }}">
                                    1. {{ app()->getLocale() === 'fr' ? 'Dépôt' : (app()->getLocale() === 'en' ? 'Submitted' : 'تقديم الطعن') }}
                                </div>
                                <div class="p-2 rounded-xl {{ in_array($app->status, ['UNDER_REVIEW', 'INVESTIGATING', 'APPROVED', 'REJECTED']) ? 'bg-blue-50 text-blue-700 border border-blue-200 font-bold' : 'text-slate-400' }}">
                                    2. {{ app()->getLocale() === 'fr' ? 'Examen Tech' : (app()->getLocale() === 'en' ? 'Tech Review' : 'المراجعة الفنية') }}
                                </div>
                                <div class="p-2 rounded-xl {{ in_array($app->status, ['INVESTIGATING', 'APPROVED', 'REJECTED']) ? 'bg-amber-50 text-amber-700 border border-amber-200 font-bold' : 'text-slate-400' }}">
                                    3. {{ app()->getLocale() === 'fr' ? 'Enquête' : (app()->getLocale() === 'en' ? 'Investigating' : 'التحقيق والتحري') }}
                                </div>
                                <div class="p-2 rounded-xl {{ in_array($app->status, ['APPROVED', 'REJECTED']) ? ($app->status === 'APPROVED' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold' : 'bg-rose-50 text-rose-700 border border-rose-200 font-bold') : 'text-slate-400' }}">
                                    4. {{ app()->getLocale() === 'fr' ? 'Décision' : (app()->getLocale() === 'en' ? 'Decision' : 'القرار والنتيجة') }}
                                </div>
                            </div>
                        </div>

                        @if($app->decision)
                            <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-200 text-xs text-emerald-900 font-medium">
                                <strong>{{ app()->getLocale() === 'fr' ? 'Décision du Jury:' : (app()->getLocale() === 'en' ? 'Jury Final Decision:' : 'القرار النهائي لهيئة التحكيم:') }}</strong> {{ $app->decision->summary ?? 'Approuvé' }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 text-center text-slate-400 font-bold border border-slate-200">
                        {{ app()->getLocale() === 'fr' ? 'Aucun recours enregistré.' : (app()->getLocale() === 'en' ? 'No technical appeals logged.' : 'لا توجد طعون فنية مسجلة حالياً للوفد.') }}
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- TAB 4: LEGAL REGULATIONS & CONSTITUTIONAL RULES -->
    @if(($activeTab ?? 'roster') === 'rules')
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('guide.regulations') }}" target="_blank" class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition space-y-3 block group">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-[#0066FF] flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#06205C] group-hover:text-[#0066FF] transition flex items-center justify-between">
                        <span>{{ app()->getLocale() === 'fr' ? 'Guide & Règlements Officiels' : (app()->getLocale() === 'en' ? 'Official Guide & Regulations' : 'الدليل واللوائح التنظيمية الرسمية') }}</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">{{ app()->getLocale() === 'fr' ? 'Référence complète des 12 sections d\'organisation, critères de notation et normes HSE.' : (app()->getLocale() === 'en' ? 'Comprehensive reference covering 12 organizational sections, scoring criteria, and HSE safety rules.' : 'المرجع الشامل للـ 12 قسم المنظمة للمنافسة، معايير التحكيم والتنقيط، والسلامة والبيئة (HSE).') }}</p>
                </a>

                <a href="{{ route('regulations') }}" target="_blank" class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition space-y-3 block group">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#06205C] group-hover:text-amber-600 transition flex items-center justify-between">
                        <span>{{ app()->getLocale() === 'fr' ? 'Télécharger Règlements PDF' : (app()->getLocale() === 'en' ? 'Download Regulations PDF' : 'تحميل ملفات اللوائح PDF') }}</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">{{ app()->getLocale() === 'fr' ? 'Téléchargement du règlement général et du guide des équipements PPE.' : (app()->getLocale() === 'en' ? 'Download general competition rules and PPE safety equipment guidelines.' : 'تحميل ملف اللوائح العامة المعتمدة لمسابقات أولمبياد المهن ودليل معدات السلامة PPE.') }}</p>
                </a>

                <a href="{{ route('privacy') }}" target="_blank" class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition space-y-3 block group">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#06205C] group-hover:text-emerald-600 transition flex items-center justify-between">
                        <span>{{ app()->getLocale() === 'fr' ? 'Politique de Confidentialité' : (app()->getLocale() === 'en' ? 'Privacy Policy' : 'سياسة الخصوصية وحماية البيانات') }}</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">{{ app()->getLocale() === 'fr' ? 'Protection des données personnelles conformément aux réglementations.' : (app()->getLocale() === 'en' ? 'Personal data protection compliance with national standards.' : 'التزام المنصة بحماية البيانات الشخصية وفق التشريعات الوطنية والتنظيمية.') }}</p>
                </a>

                <a href="{{ route('terms') }}" target="_blank" class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition space-y-3 block group">
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#06205C] group-hover:text-purple-600 transition flex items-center justify-between">
                        <span>{{ app()->getLocale() === 'fr' ? 'Conditions d\'Utilisation' : (app()->getLocale() === 'en' ? 'Terms & Conditions' : 'شروط وأحكام الاستخدام') }}</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">{{ app()->getLocale() === 'fr' ? 'Règles d\'utilisation du portail officiel et droits des délégations.' : (app()->getLocale() === 'en' ? 'Official portal usage rules and delegation user rights.' : 'قواعد استخدام المنصة الرسمية وحقوق الوفود والمشاركين.') }}</p>
                </a>
            </div>
        </div>
    @endif

    <!-- MODAL 1: ADD MEMBER MODAL -->
    @if($showAddModal ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data>
            <div class="bg-white rounded-3xl max-w-2xl w-full p-6 space-y-6 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-[#06205C]">{{ app()->getLocale() === 'fr' ? 'Ajouter un Membre à la Délégation' : (app()->getLocale() === 'en' ? 'Add Member to Delegation' : 'إضافة عضو جديد للوفد الرسمي') }}</h3>
                    <button wire:click="$set('showAddModal', false)" class="text-slate-400 hover:text-slate-600 font-bold text-sm">✕</button>
                </div>

                <form wire:submit.prevent="addMember" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Prénom *' : (app()->getLocale() === 'en' ? 'First Name *' : 'الاسم الأول *') }}</label>
                            <input type="text" wire:model="firstName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Nom *' : (app()->getLocale() === 'en' ? 'Last Name *' : 'اللقب *') }}</label>
                            <input type="text" wire:model="lastName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Rôle / Catégorie *' : (app()->getLocale() === 'en' ? 'Category / Role *' : 'الصفة / الفئة بالوفد *') }}</label>
                            <select wire:model="memberType" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="PARTICIPANT">PARTICIPANT — {{ app()->getLocale() === 'fr' ? 'Compétiteur' : (app()->getLocale() === 'en' ? 'Competitor' : 'متنافس') }}</option>
                                <option value="JUDGE">JUDGE — {{ app()->getLocale() === 'fr' ? 'Juge' : (app()->getLocale() === 'en' ? 'Judge' : 'حكم') }}</option>
                                <option value="PRESS">PRESS — {{ app()->getLocale() === 'fr' ? 'Presse / Média' : (app()->getLocale() === 'en' ? 'Press / Media' : 'صحفي / إعلامي') }}</option>
                                <option value="SUPERVISOR">SUPERVISOR — {{ app()->getLocale() === 'fr' ? 'Encadrant' : (app()->getLocale() === 'en' ? 'Supervisor' : 'مؤطر / قائد فريق') }}</option>
                                <option value="VIP">VIP — {{ app()->getLocale() === 'fr' ? 'VIP' : (app()->getLocale() === 'en' ? 'VIP' : 'شخصية مرموقة') }}</option>
                                <option value="EXPERT">EXPERT — {{ app()->getLocale() === 'fr' ? 'Expert Technique' : (app()->getLocale() === 'en' ? 'Technical Expert' : 'خبير تحكيم') }}</option>
                                <option value="OFFICIAL">OFFICIAL — {{ app()->getLocale() === 'fr' ? 'Officiel' : (app()->getLocale() === 'en' ? 'Official' : 'مسؤول رسمي') }}</option>
                                <option value="SUPPORT_STAFF">SUPPORT_STAFF — {{ app()->getLocale() === 'fr' ? 'Equipe Support' : (app()->getLocale() === 'en' ? 'Support Staff' : 'طاقم دعم') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Métier / Discipline' : (app()->getLocale() === 'en' ? 'Assigned Skill' : 'المهنة التنافسية (إن وجد)') }}</label>
                            <select wire:model="skillId" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="">-- {{ app()->getLocale() === 'fr' ? 'Non spécifié' : (app()->getLocale() === 'en' ? 'Not specified' : 'بدون تخصص معين') }} --</option>
                                @foreach($skills as $sk)
                                    <option value="{{ $sk->id }}">{{ $sk->code }} — {{ $sk->getLocalized('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Numéro de Passeport' : (app()->getLocale() === 'en' ? 'Passport Number' : 'رقم الجواز') }}</label>
                            <input type="text" wire:model="passportNumber" placeholder="PASS-123456" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Numéro d\'Identité (NIN)' : (app()->getLocale() === 'en' ? 'NIN Number' : 'رقم التعريف الوطني (NIN)') }}</label>
                            <input type="text" wire:model="ninNumber" placeholder="10000200..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Genre *' : (app()->getLocale() === 'en' ? 'Gender *' : 'الجنس *') }}</label>
                            <select wire:model="gender" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="male">{{ app()->getLocale() === 'fr' ? 'Homme (Male)' : (app()->getLocale() === 'en' ? 'Male' : 'ذكر (Male)') }}</option>
                                <option value="female">{{ app()->getLocale() === 'fr' ? 'Femme (Female)' : (app()->getLocale() === 'en' ? 'Female' : 'أنثى (Female)') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Taille Vêtement' : (app()->getLocale() === 'en' ? 'Suit Size' : 'قياس البدلة') }}</label>
                            <input type="text" wire:model="suitSize" placeholder="M / L / 50" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Pointure Chaussures' : (app()->getLocale() === 'en' ? 'Shoe Size' : 'قياس الحذاء') }}</label>
                            <input type="text" wire:model="shoeSize" placeholder="42" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" wire:click="$set('showAddModal', false)" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">{{ app()->getLocale() === 'fr' ? 'Annuler' : (app()->getLocale() === 'en' ? 'Cancel' : 'إلغاء') }}</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow-md">{{ app()->getLocale() === 'fr' ? 'Enregistrer Membre' : (app()->getLocale() === 'en' ? 'Save Member' : 'حفظ وإضافة العضو') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL 1.5: EDIT MEMBER MODAL -->
    @if($showEditModal ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data>
            <div class="bg-white rounded-3xl max-w-2xl w-full p-6 space-y-6 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-[#06205C]">{{ app()->getLocale() === 'fr' ? 'Modifier Membre de la Délégation' : (app()->getLocale() === 'en' ? 'Edit Delegation Member' : 'تعديل بيانات عضو الوفد الرسمي') }}</h3>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-400 hover:text-slate-600 font-bold text-sm">✕</button>
                </div>

                <form wire:submit.prevent="updateMember" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Prénom *' : (app()->getLocale() === 'en' ? 'First Name *' : 'الاسم الأول *') }}</label>
                            <input type="text" wire:model="firstName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Nom *' : (app()->getLocale() === 'en' ? 'Last Name *' : 'اللقب *') }}</label>
                            <input type="text" wire:model="lastName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Rôle / Catégorie *' : (app()->getLocale() === 'en' ? 'Category / Role *' : 'الصفة / الفئة بالوفد *') }}</label>
                            <select wire:model="memberType" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="MINISTERIAL_OBSERVER">MINISTERIAL_OBSERVER — {{ app()->getLocale() === 'fr' ? 'Observateur Exécutif / Ministre' : (app()->getLocale() === 'en' ? 'Ministerial Executive Observer' : 'وزير / مراقب تنفيذي') }}</option>
                                <option value="DELEGATION_HEAD">DELEGATION_HEAD — {{ app()->getLocale() === 'fr' ? 'Chef de Délégation' : (app()->getLocale() === 'en' ? 'Head of Delegation' : 'مسؤول الوفد') }}</option>
                                <option value="PARTICIPANT">PARTICIPANT — {{ app()->getLocale() === 'fr' ? 'Compétiteur' : (app()->getLocale() === 'en' ? 'Competitor' : 'متنافس') }}</option>
                                <option value="JUDGE">JUDGE — {{ app()->getLocale() === 'fr' ? 'Juge' : (app()->getLocale() === 'en' ? 'Judge' : 'حكم') }}</option>
                                <option value="PRESS">PRESS — {{ app()->getLocale() === 'fr' ? 'Presse / Média' : (app()->getLocale() === 'en' ? 'Press / Media' : 'صحفي / إعلامي') }}</option>
                                <option value="SUPERVISOR">SUPERVISOR — {{ app()->getLocale() === 'fr' ? 'Encadrant' : (app()->getLocale() === 'en' ? 'Supervisor' : 'مؤطر / قائد فريق') }}</option>
                                <option value="VIP">VIP — {{ app()->getLocale() === 'fr' ? 'VIP' : (app()->getLocale() === 'en' ? 'VIP' : 'شخصية مرموقة') }}</option>
                                <option value="EXPERT">EXPERT — {{ app()->getLocale() === 'fr' ? 'Expert Technique' : (app()->getLocale() === 'en' ? 'Technical Expert' : 'خبير تحكيم') }}</option>
                                <option value="OFFICIAL">OFFICIAL — {{ app()->getLocale() === 'fr' ? 'Officiel' : (app()->getLocale() === 'en' ? 'Official' : 'مسؤول رسمي') }}</option>
                                <option value="SUPPORT_STAFF">SUPPORT_STAFF — {{ app()->getLocale() === 'fr' ? 'Equipe Support' : (app()->getLocale() === 'en' ? 'Support Staff' : 'طاقم دعم') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Métier / Discipline' : (app()->getLocale() === 'en' ? 'Assigned Skill' : 'المهنة التنافسية (إن وجد)') }}</label>
                            <select wire:model="skillId" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="">-- {{ app()->getLocale() === 'fr' ? 'Non spécifié' : (app()->getLocale() === 'en' ? 'Not specified' : 'بدون تخصص معين') }} --</option>
                                @foreach($skills as $sk)
                                    <option value="{{ $sk->id }}">{{ $sk->code }} — {{ $sk->getLocalized('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Statut *' : (app()->getLocale() === 'en' ? 'Status *' : 'حالة الاعتماد *') }}</label>
                            <select wire:model="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="APPROVED">Approved — {{ app()->getLocale() === 'fr' ? 'Approuvé' : (app()->getLocale() === 'en' ? 'Approved' : 'معتمد') }}</option>
                                <option value="PENDING">Pending — {{ app()->getLocale() === 'fr' ? 'En Attente' : (app()->getLocale() === 'en' ? 'Pending' : 'قيد المراجعة') }}</option>
                                <option value="REJECTED">Rejected — {{ app()->getLocale() === 'fr' ? 'Rejeté' : (app()->getLocale() === 'en' ? 'Rejected' : 'مرفوض') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Numéro de Passeport' : (app()->getLocale() === 'en' ? 'Passport Number' : 'رقم الجواز') }}</label>
                            <input type="text" wire:model="passportNumber" placeholder="PASS-123456" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Numéro NIN' : (app()->getLocale() === 'en' ? 'NIN Number' : 'رقم التعريف الوطني (NIN)') }}</label>
                            <input type="text" wire:model="ninNumber" placeholder="10000200..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Taille Vêtement' : (app()->getLocale() === 'en' ? 'Suit Size' : 'قياس البدلة') }}</label>
                            <input type="text" wire:model="suitSize" placeholder="M / L / 50" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Pointure Chaussures' : (app()->getLocale() === 'en' ? 'Shoe Size' : 'قياس الحذاء') }}</label>
                            <input type="text" wire:model="shoeSize" placeholder="42" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" wire:click="$set('showEditModal', false)" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">{{ app()->getLocale() === 'fr' ? 'Annuler' : (app()->getLocale() === 'en' ? 'Cancel' : 'إلغاء') }}</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow-md">{{ app()->getLocale() === 'fr' ? 'Enregistrer Modifications' : (app()->getLocale() === 'en' ? 'Save Changes' : 'حفظ التعديلات') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL 2: TECHNICAL APPEAL MODAL -->
    @if($showAppealModal ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data>
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-6 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-[#06205C]">{{ app()->getLocale() === 'fr' ? 'Déposer un Nouveau Recours' : (app()->getLocale() === 'en' ? 'Submit New Technical Appeal' : 'تقديم طعن فني جديد') }}</h3>
                    <button wire:click="$set('showAppealModal', false)" class="text-slate-400 hover:text-slate-600 font-bold text-sm">✕</button>
                </div>

                <form wire:submit.prevent="submitTechnicalAppeal" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Discipline Concernée *' : (app()->getLocale() === 'en' ? 'Concerned Skill *' : 'التخصص المعني بالطعن *') }}</label>
                        <select wire:model="appealSkillId" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="">-- {{ app()->getLocale() === 'fr' ? 'Choisir la discipline' : (app()->getLocale() === 'en' ? 'Select skill' : 'اختر التخصص') }} --</option>
                            @foreach($skills as $sk)
                                <option value="{{ $sk->id }}">{{ $sk->code }} — {{ $sk->getLocalized('name') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Sujet du Recours *' : (app()->getLocale() === 'en' ? 'Appeal Subject *' : 'موضوع الطعن الفني *') }}</label>
                        <input type="text" wire:model="appealSubject" required placeholder="..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Détails & Motivations *' : (app()->getLocale() === 'en' ? 'Details & Justification *' : 'تفاصيل ومبررات الطعن الفني *') }}</label>
                        <textarea wire:model="appealDescription" required rows="4" placeholder="..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Degré de Priorité' : (app()->getLocale() === 'en' ? 'Priority Level' : 'درجة الأولوية') }}</label>
                        <select wire:model="appealPriority" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="LOW">Low — {{ app()->getLocale() === 'fr' ? 'Basse' : (app()->getLocale() === 'en' ? 'Low' : 'عادية') }}</option>
                            <option value="MEDIUM">Medium — {{ app()->getLocale() === 'fr' ? 'Moyenne' : (app()->getLocale() === 'en' ? 'Medium' : 'متوسطة') }}</option>
                            <option value="HIGH">High — {{ app()->getLocale() === 'fr' ? 'Haute' : (app()->getLocale() === 'en' ? 'High' : 'عالية') }}</option>
                            <option value="URGENT">Urgent — {{ app()->getLocale() === 'fr' ? 'Urgente' : (app()->getLocale() === 'en' ? 'Urgent' : 'استعجالية') }}</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" wire:click="$set('showAppealModal', false)" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">{{ app()->getLocale() === 'fr' ? 'Annuler' : (app()->getLocale() === 'en' ? 'Cancel' : 'إلغاء') }}</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md">{{ app()->getLocale() === 'fr' ? 'Déposer Recours' : (app()->getLocale() === 'en' ? 'Submit Appeal' : 'إيداع الطعن') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL 3: VIEW DOSSIER MODAL -->
    @if(($showViewModal ?? false) && ($viewingMember ?? null))
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data>
            <div class="bg-white rounded-3xl max-w-xl w-full p-6 space-y-6 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-[#06205C]">{{ app()->getLocale() === 'fr' ? 'Dossier Unifié du Membre' : (app()->getLocale() === 'en' ? 'Unified Member Dossier' : 'الملف التوصيفي الموحد للعضو') }}</h3>
                    <button wire:click="$set('showViewModal', false)" class="text-slate-400 hover:text-slate-600 font-bold text-sm">✕</button>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <div class="w-14 h-14 rounded-2xl bg-[#0066FF] text-white font-black flex items-center justify-center text-lg">
                            {{ mb_substr($viewingMember->first_name, 0, 1) }}{{ mb_substr($viewingMember->last_name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-base font-black text-slate-900">{{ $viewingMember->full_name }}</h4>
                            <p class="text-xs text-blue-600 font-bold mt-0.5">{{ $viewingMember->member_type }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Discipline' : (app()->getLocale() === 'en' ? 'Assigned Skill' : 'المهنة المخصصة') }}</span>
                            <span class="font-bold text-slate-800 text-xs">{{ $viewingMember->skill ? $viewingMember->skill->code . ' - ' . $viewingMember->skill->getLocalized('name') : '—' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Statut Approbation' : (app()->getLocale() === 'en' ? 'Approval Status' : 'حالة الاعتماد') }}</span>
                            <span class="font-bold text-xs {{ $viewingMember->status === 'APPROVED' ? 'text-emerald-600' : 'text-amber-600' }}">{{ $viewingMember->status }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Numéro de Passeport' : (app()->getLocale() === 'en' ? 'Passport Number' : 'رقم الجواز') }}</span>
                            <span class="font-mono font-bold text-slate-800 text-xs">{{ $viewingMember->passport_number ?: '—' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Numéro NIN' : (app()->getLocale() === 'en' ? 'NIN Number' : 'رقم التعريف الوطني (NIN)') }}</span>
                            <span class="font-mono font-bold text-slate-800 text-xs">{{ $viewingMember->nin_number ?: '—' }}</span>
                        </div>
                    </div>

                    <!-- Official Candidate Accreditation Badge Section -->
                    <div class="space-y-3 p-4 rounded-2xl bg-gradient-to-br from-[#06205C] to-[#0052CC] text-white shadow-md relative overflow-hidden">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <h4 class="text-xs font-black uppercase text-amber-300">
                                    {{ app()->getLocale() === 'fr' ? 'Badge Officiel d\'Accréditation' : (app()->getLocale() === 'en' ? 'Official Accreditation Pass Badge' : 'شارة الاعتماد وبطاقة التربص الرسمية') }}
                                </h4>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3 pt-1">
                            <a href="{{ route('accreditation.badge', ['identifier' => $viewingMember->uuid ?? $viewingMember->id]) }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-950 font-black text-xs transition text-center shadow-md flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                                <span>{{ app()->getLocale() === 'fr' ? 'Afficher & Imprimer le Badge ↗' : (app()->getLocale() === 'en' ? 'View & Print Badge ↗' : 'عرض وطباعة شارة الاعتماد (Badge Pass) ↗') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="$set('showViewModal', false)" class="px-5 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">{{ app()->getLocale() === 'fr' ? 'Fermer' : (app()->getLocale() === 'en' ? 'Close' : 'إغلاق') }}</button>
                </div>
            </div>
        </div>
    @endif

</div>
