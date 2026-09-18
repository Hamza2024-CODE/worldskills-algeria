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

<div class="space-y-6 select-none">

    {{-- SUCCESS FLASH BANNER --}}
    @if (session()->has('success') || session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-100 font-bold text-xs flex items-center justify-between shadow-md">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') ?? session('message') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
    @endif

    {{-- TOP TITLE HEADER CAPSULE --}}
    <div class="bg-gradient-to-r from-[#06205C] via-[#0A3580] to-[#0052CC] rounded-3xl p-6 text-white shadow-xl border border-white/10 relative overflow-hidden">
        <div class="absolute -end-10 -bottom-10 w-48 h-48 bg-blue-400/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative z-10">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-bold text-blue-200 backdrop-blur-md">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                    </svg>
                    <span>{{ $t('المركز اللوجستي والعمليات الأمني الموحد', 'Centre Logistique & Opérations', 'Logistics Operations Center') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    {{ $t('إدارة رحلات وصول الوفود وحافلات الاستقبال', 'Gestion des Arrivées & Navettes Protocolaires', 'Delegation Arrivals & Shuttle Management') }}
                </h1>
                <p class="text-xs sm:text-sm text-blue-100 font-medium">
                    {{ $t('متابعة لحظية لرحلات الطيران القادمة، معاينة التذاكر، وتخصيص حافلات الاستقبال للوفود المشاركة.', 'Suivi en temps réel des vols, billetterie et affectation des navettes aux délégations.', 'Real-time flight arrival tracking, ticket verification, and protocol shuttle bus assignment.') }}
                </p>
            </div>

            <div class="flex items-center gap-2 flex-wrap shrink-0">
                <button type="button" wire:click="openCreateModal"
                    class="px-5 py-3 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs transition shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>{{ $t('إضافة وصول وفد جديد', 'Ajouter une Arrivée', 'Add New Arrival') }}</span>
                </button>
                <button type="button" onclick="window.print()"
                    class="px-4 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition border border-white/20 flex items-center gap-2 backdrop-blur-md">
                    <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-19.126 0C1.068 7.44 1 8.375 1 9.456v6.294A2.25 2.25 0 003.25 18h1.091"/>
                    </svg>
                    <span>{{ $t('طباعة الكشف اللوجستي', 'Imprimer le Registre', 'Print Register') }}</span>
                </button>
            </div>
        </div>
    </div>

    {{-- REAL DATABASE METRIC STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">{{ $t('إجمالي رحلات الوصول المسجلة', 'Total des Vols Enregistrés', 'Total Arrival Flights') }}</span>
                <span class="text-2xl font-black text-slate-900 dark:text-white font-mono">{{ $totalArrivalsCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-[#0052CC] dark:text-blue-400 flex items-center justify-center border border-blue-200 dark:border-blue-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3 21l9-3 9 3-3-9M6 12l9-3-9-3m0 6h15"/></svg>
            </div>
        </div>

        <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">{{ $t('إجمالي الأعضاء والركاب القادمون', 'Total des Délégués & Passagers', 'Total Delegates & Passengers') }}</span>
                <span class="text-2xl font-black text-amber-500 font-mono">{{ $totalDelegatesCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center border border-amber-200 dark:border-amber-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">{{ $t('الاستقبال المعتمد والتأطير المكتمل', 'Accueils Confirmés & Navettes', 'Confirmed Arrivals & Shuttles') }}</span>
                <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400 font-mono">{{ $approvedCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-200 dark:border-emerald-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">{{ $t('رحلات قيد المراجعة وتخصيص الحافلات', 'Vols en Attente de Traitement', 'Pending Flight Inspections') }}</span>
                <span class="text-2xl font-black text-rose-500 font-mono">{{ $pendingCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center border border-rose-200 dark:border-rose-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

    </div>

    {{-- SEARCH & FILTERS BAR --}}
    <div class="bg-white dark:bg-slate-800 p-4 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        
        {{-- LIVE SEARCH INPUT --}}
        <div class="relative w-full md:w-96">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="{{ $t('ابحث برقم الرحلة، شركة الطيران، اسم الدولة أو المطار...', 'Rechercher par vol, compagnie, pays...', 'Search by flight #, airline, country...') }}"
                class="w-full pe-4 ps-10 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
            <svg class="w-4 h-4 text-slate-400 absolute start-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
        </div>

        {{-- FILTERS DROPDOWNS --}}
        <div class="flex items-center gap-3 w-full md:w-auto flex-wrap justify-end">
            <select wire:model.live="statusFilter"
                class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none font-bold">
                <option value="ALL">{{ $t('جميع الحالات', 'Tous les statuts', 'All Statuses') }}</option>
                <option value="PENDING">{{ $t('قيد المراجعة والمعاينة', 'En Attente', 'Pending Review') }}</option>
                <option value="APPROVED">{{ $t('معتمدة ومخصص لها الاستقبال', 'Approuvé & Assigné', 'Approved & Assigned') }}</option>
                <option value="CANCELLED">{{ $t('ملغاة', 'Annulé', 'Cancelled') }}</option>
            </select>

            <select wire:model.live="airportFilter"
                class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none font-bold">
                <option value="ALL">{{ $t('جميع المطارات المعتمدة', 'Tous les Aéroports', 'All Airports') }}</option>
                <option value="هواري بومدين">مطار هواري بومدين (الجزائر العاصمة)</option>
                <option value="أحمد بن بلة">مطار أحمد بن بلة (وهران)</option>
                <option value="محمد بوضياف">مطار محمد بوضياف (قسنطينة)</option>
            </select>
        </div>
    </div>

    {{-- ARRIVALS TABLE REGISTER --}}
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <h2 class="text-base sm:text-lg font-black text-[#06205C] dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-[#0052CC] dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>{{ $t('جدول وصول الوفود والمعاينة الفورية لتذاكر الطيران', 'Registre des Arrivées & Billets d'Avion', 'Delegation Arrivals & Ticket Inspection Register') }}</span>
            </h2>
            <span class="text-xs font-mono font-bold text-slate-500">
                {{ $arrivals->total() }} {{ $t('سجل وصول', 'entrées', 'records') }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-900/90 text-slate-600 dark:text-slate-400 uppercase font-mono border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="py-4 px-6 text-start">{{ $t('الدولة والوفد', 'Pays & Délégation', 'Country & Delegation') }}</th>
                        <th class="py-4 px-6 text-start">{{ $t('شركة الطيران والرحلة', 'Compagnie & Vol', 'Airline & Flight') }}</th>
                        <th class="py-4 px-6 text-start">{{ $t('تاريخ ووقت الوصول', 'Date & Heure d'Arrivée', 'Arrival Date & Time') }}</th>
                        <th class="py-4 px-6 text-start">{{ $t('عدد الركاب', 'Passagers', 'Passengers') }}</th>
                        <th class="py-4 px-6 text-start">{{ $t('مطار الوصول والحافلة', 'Aéroport & Navette', 'Airport & Shuttle') }}</th>
                        <th class="py-4 px-6 text-center">{{ $t('تذكرة الطيران', 'Billet', 'Flight Ticket') }}</th>
                        <th class="py-4 px-6 text-center">{{ $t('حالة الاستقبال', 'Statut Accueil', 'Status') }}</th>
                        <th class="py-4 px-6 text-center me-2">{{ $t('الإجراءات والعمليات', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($arrivals as $item)
                        @php
                            $cName = $item->country ? ($locale === 'fr' ? ($item->country->name_fr ?? $item->country->name_en) : ($locale === 'en' ? $item->country->name_en : $item->country->name_ar)) : 'الجزائر';
                            $cCode = $item->country->code ?? 'DZA';
                            $flag = $item->country?->flag_emoji ?? '🇩🇿';
                        @endphp
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/40 transition">
                            
                            {{-- Country & Delegation --}}
                            <td class="py-4 px-6 font-bold">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-900 font-mono font-black flex items-center justify-center text-sm shadow-2xs">
                                        {{ $flag }}
                                    </div>
                                    <div>
                                        <span class="font-black text-slate-900 dark:text-white text-sm block">{{ $cName }}</span>
                                        <span class="text-[10px] font-mono text-slate-400 block">CODE: {{ $cCode }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Airline & Flight # --}}
                            <td class="py-4 px-6 font-bold">
                                <span class="text-slate-900 dark:text-white block font-black">{{ $item->airline_name }}</span>
                                <span class="font-mono text-xs text-[#0052CC] dark:text-sky-300 block pt-0.5">
                                    ✈️ {{ $item->flight_number }}
                                </span>
                            </td>

                            {{-- Arrival Date & Time --}}
                            <td class="py-4 px-6 font-mono font-bold text-slate-900 dark:text-white">
                                <span class="block font-black text-slate-900 dark:text-slate-100">
                                    {{ $item->arrival_date ? \Carbon\Carbon::parse($item->arrival_date)->format('Y/m/d') : '—' }}
                                </span>
                                <span class="text-[11px] text-slate-500 font-sans block pt-0.5">
                                    🕒 {{ $item->arrival_time ?: '12:00' }}
                                </span>
                            </td>

                            {{-- Passenger Count --}}
                            <td class="py-4 px-6 font-bold">
                                <span class="px-3 py-1 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-900 dark:text-amber-300 border border-amber-300/60 font-black text-xs inline-block">
                                    👥 {{ $item->passenger_count }} {{ $t('شخص', 'personnes', 'delegates') }}
                                </span>
                            </td>

                            {{-- Airport & Shuttle --}}
                            <td class="py-4 px-6 font-medium">
                                <span class="text-slate-800 dark:text-slate-200 font-bold block truncate max-w-[180px]" title="{{ $item->arrival_airport }}">
                                    📍 {{ $item->arrival_airport }}
                                </span>
                                <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-bold block pt-0.5 truncate max-w-[180px]" title="{{ $item->shuttle_assigned }}">
                                    🚌 {{ $item->shuttle_assigned ?: 'حافلة بروتوكولية VIP' }}
                                </span>
                            </td>

                            {{-- Ticket File Preview --}}
                            <td class="py-4 px-6 text-center">
                                <button type="button" wire:click="openTicketPreview({{ $item->id }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-200 border border-blue-200 dark:border-blue-800 text-xs font-bold hover:bg-blue-100 transition shadow-2xs">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>{{ $item->ticket_filename ? $t('معاينة التذكرة', 'Voir Billet', 'View Ticket') : $t('تذكرة افتراضية', 'Billet Virtuel', 'Virtual Ticket') }}</span>
                                </button>
                            </td>

                            {{-- Status Badge --}}
                            <td class="py-4 px-6 text-center">
                                @if($item->status === 'APPROVED')
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 dark:bg-emerald-950 text-emerald-900 dark:text-emerald-200 border border-emerald-300 dark:border-emerald-700 flex items-center justify-center gap-1 mx-auto max-w-[140px]">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>{{ $t('تم اعتماد الاستقبال', 'Accueil Confirmé', 'Arrival Confirmed') }}</span>
                                    </span>
                                @elseif($item->status === 'CANCELLED')
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-100 dark:bg-rose-950 text-rose-900 dark:text-rose-200 border border-rose-300 dark:border-rose-700 flex items-center justify-center gap-1 mx-auto max-w-[140px]">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        <span>{{ $t('رحلة ملغاة', 'Vol Annulé', 'Cancelled') }}</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 dark:bg-amber-950 text-amber-900 dark:text-amber-200 border border-amber-300 dark:border-amber-700 flex items-center justify-center gap-1 mx-auto max-w-[140px] animate-pulse">
                                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                        <span>{{ $t('جاري مراجعة اللوجستيك', 'En Cours', 'Processing') }}</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    {{-- Approve & Assign Shuttle Button --}}
                                    @if($item->status !== 'APPROVED')
                                        <button type="button" wire:click="openApproveModal({{ $item->id }})" title="{{ $t('اعتماد الاستقبال وتعيين الحافلة', 'Approuver & Navette', 'Approve & Assign Shuttle') }}"
                                            class="p-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endif

                                    {{-- Edit Button --}}
                                    <button type="button" wire:click="editArrival({{ $item->id }})" title="{{ $t('تعديل البيانات', 'Modifier', 'Edit') }}"
                                        class="p-2 rounded-xl bg-blue-50 dark:bg-blue-900/60 text-blue-700 dark:text-blue-200 hover:bg-blue-100 transition border border-blue-200 dark:border-blue-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                    </button>

                                    {{-- Delete Button --}}
                                    <button type="button" wire:confirm="{{ $t('هل أنت تأكد من ترغبتك في حذف سجل الوصول هذا؟', 'Confirmer la suppression ?', 'Confirm deletion?') }}" wire:click="deleteArrival({{ $item->id }})" title="{{ $t('حذف', 'Supprimer', 'Delete') }}"
                                        class="p-2 rounded-xl bg-rose-50 dark:bg-rose-900/60 text-rose-700 dark:text-rose-200 hover:bg-rose-100 transition border border-rose-200 dark:border-rose-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400 text-xs font-bold space-y-2">
                                <svg class="w-10 h-10 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                <p>{{ $t('لا توجد بيانات وصول مسجلة تطابق التصفية الحالية', 'Aucune arrivée ne correspond aux critères', 'No arrival records matching criteria') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION LINKS --}}
        <div class="p-4 border-t border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
            {{ $arrivals->links() }}
        </div>
    </div>

    {{-- MODAL 1: ADD / EDIT ARRIVAL FORM --}}
    @if($showFormModal)
    <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-2xl w-full p-6 space-y-5 shadow-2xl border border-slate-200 dark:border-slate-700">
            
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                <h3 class="text-base font-black text-[#06205C] dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#0052CC]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>{{ $editingId ? $t('تعديل بيانات وصول الوفد', 'Modifier l Arrivée', 'Edit Arrival') : $t('إضافة وصول وفد جديد وتخصيص الرحلة', 'Nouveau Vol d Arrivée', 'New Delegation Arrival') }}</span>
                </h3>
                <button type="button" wire:click="$set('showFormModal', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>

            <form wire:submit.prevent="saveArrival" class="space-y-4 text-xs">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    {{-- Country --}}
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الدولة / الوفد الرسمي *', 'Pays / Délégation *', 'Country / Delegation *') }}</label>
                        <select wire:model="country_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                            @foreach($allCountries as $c)
                                <option value="{{ $c->id }}">{{ $c->flag_emoji }} {{ $c->name_ar }} ({{ $c->code }})</option>
                            @endforeach
                        </select>
                        @error('country_id') <span class="text-rose-500 font-bold block pt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Passenger Count --}}
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('عدد الركاب والأعضاء *', 'Nombre de Passagers *', 'Passenger Count *') }}</label>
                        <input type="number" min="1" wire:model="passenger_count" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                        @error('passenger_count') <span class="text-rose-500 font-bold block pt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Airline Name --}}
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('شركة الطيران *', 'Compagnie Aérienne *', 'Airline Name *') }}</label>
                        <input type="text" wire:model="airline_name" required placeholder="مثال: الخطوط الجوية الجزائرية" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                        @error('airline_name') <span class="text-rose-500 font-bold block pt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Flight Number --}}
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('رقم الرحلة *', 'N° de Vol *', 'Flight Number *') }}</label>
                        <input type="text" wire:model="flight_number" required placeholder="مثال: AH-1004" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-mono font-bold text-xs">
                        @error('flight_number') <span class="text-rose-500 font-bold block pt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Arrival Date --}}
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('تاريخ الوصول *', 'Date d Arrivée *', 'Arrival Date *') }}</label>
                        <input type="date" wire:model="arrival_date" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                        @error('arrival_date') <span class="text-rose-500 font-bold block pt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Arrival Time --}}
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('وقت الوصول المخطط *', 'Heure d Arrivée *', 'Arrival Time *') }}</label>
                        <input type="time" wire:model="arrival_time" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                        @error('arrival_time') <span class="text-rose-500 font-bold block pt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Arrival Airport --}}
                    <div class="sm:col-span-2">
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('مطار الوصول المعتمد *', 'Aéroport d Arrivée *', 'Arrival Airport *') }}</label>
                        <input type="text" wire:model="arrival_airport" required placeholder="مثال: مطار هواري بومدين الدولي (الجزائر العاصمة)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                        @error('arrival_airport') <span class="text-rose-500 font-bold block pt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Shuttle Assigned --}}
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الحافلة أو وسيلة النقل المخصصة', 'Navette Assignée', 'Shuttle Assigned') }}</label>
                        <input type="text" wire:model="shuttle_assigned" placeholder="مثال: حافلة بروتوكولية فاخرة (VIP Bus 01)" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('حالة الاستقبال والاعتماد *', 'Statut *', 'Status *') }}</label>
                        <select wire:model="status" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                            <option value="PENDING">قيد المراجعة والمعاينة (PENDING)</option>
                            <option value="APPROVED">تم اعتماد الاستقبال وتأكيد الحافلة (APPROVED)</option>
                            <option value="CANCELLED">رحلة ملغاة (CANCELLED)</option>
                        </select>
                    </div>

                    {{-- Ticket Upload File --}}
                    <div class="sm:col-span-2">
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('رفع تذكرة الطيران أو إثبات الرحلة (PDF, PNG, JPG)', 'Billet / Justificatif (PDF, Image)', 'Flight Ticket File (PDF, Image)') }}</label>
                        <input type="file" wire:model="ticket_file" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                        @error('ticket_file') <span class="text-rose-500 font-bold block pt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Notes --}}
                    <div class="sm:col-span-2">
                        <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('ملاحظات المتابعة والبروتوكول', 'Notes & Protocole', 'Protocol Notes') }}</label>
                        <textarea wire:model="notes" rows="2" placeholder="ملاحظات حول الأمتعة، الاستقبال بالأعلام، البروتوكول الوزاري..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs"></textarea>
                    </div>

                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" wire:click="$set('showFormModal', false)" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0052CC] hover:bg-blue-700 text-white font-black text-xs shadow-md">
                        {{ $editingId ? $t('حفظ التعديلات', 'Enregistrer Changes', 'Save Changes') : $t('تسجيل وصول الوفد', 'Enregistrer L Arrivée', 'Save Arrival Record') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
    @endif

    {{-- MODAL 2: TICKET PREVIEW MODAL --}}
    @if($previewModalOpen && $selectedArrival)
    <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <h3 class="text-base font-black text-[#06205C] dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>{{ $t('معاينة تذكرة الطيران ومعلومات وصول الوفد', 'Aperçu du Billet & Détails Vol', 'Flight Ticket & Arrival Inspector') }}</span>
                </h3>
                <button type="button" wire:click="closeTicketPreview" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>

            <div class="space-y-3 text-xs">
                <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-900 space-y-2">
                    <div class="flex justify-between items-center font-black">
                        <span class="text-slate-500">{{ $t('الوفد والدولة:', 'Délégation:', 'Delegation:') }}</span>
                        <span class="text-slate-900 dark:text-white text-sm">{{ $selectedArrival->country?->flag_emoji }} {{ $selectedArrival->country?->name_ar }}</span>
                    </div>
                    <div class="flex justify-between items-center font-mono">
                        <span class="text-slate-500 font-sans">{{ $t('شركة الطيران والرحلة:', 'Vol:', 'Flight:') }}</span>
                        <span class="font-black text-[#0052CC] dark:text-sky-300">{{ $selectedArrival->airline_name }} ({{ $selectedArrival->flight_number }})</span>
                    </div>
                    <div class="flex justify-between items-center font-bold">
                        <span class="text-slate-500">{{ $t('تاريخ ووقت الوصول:', 'Arrivée:', 'Arrival:') }}</span>
                        <span>{{ $selectedArrival->arrival_date }} @ {{ $selectedArrival->arrival_time }}</span>
                    </div>
                    <div class="flex justify-between items-center font-bold">
                        <span class="text-slate-500">{{ $t('عدد الأعضاء القادمون:', 'Passagers:', 'Passengers:') }}</span>
                        <span class="text-amber-600 font-black">{{ $selectedArrival->passenger_count }} {{ $t('شخص', 'personnes', 'delegates') }}</span>
                    </div>
                    <div class="flex justify-between items-center font-bold">
                        <span class="text-slate-500">{{ $t('الحافلة المخصصة:', 'Navette:', 'Shuttle:') }}</span>
                        <span class="text-emerald-600 font-black">{{ $selectedArrival->shuttle_assigned ?: 'حافلة بروتوكولية معتمدة' }}</span>
                    </div>
                </div>

                @if($selectedArrival->ticket_path)
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-center space-y-2">
                        <span class="block font-bold text-slate-700 dark:text-slate-300">{{ $t('ملف التذكرة المرفق:', 'Fichier du Billet:', 'Attached Ticket File:') }}</span>
                        <a href="{{ asset('storage/' . $selectedArrival->ticket_path) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#0052CC] text-white font-bold text-xs shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>{{ $selectedArrival->ticket_filename ?: 'تحميل وتصفح التذكرة' }}</span>
                        </a>
                    </div>
                @else
                    <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 text-amber-900 dark:text-amber-200 font-bold text-[11px] text-center">
                        {{ $t('ملاحظة: تذكرة افتراضية صادرة معتمدة آلياً لوفد البطولة.', 'Billet virtuel officiel généré par le système.', 'Official virtual ticket generated by system.') }}
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end pt-3 border-t border-slate-100 dark:border-slate-700">
                <button type="button" wire:click="closeTicketPreview" class="px-5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">
                    {{ $t('إغلاق', 'Fermer', 'Close') }}
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL 3: APPROVE & ASSIGN SHUTTLE MODAL --}}
    @if($approveModalOpen)
    <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <h3 class="text-base font-black text-emerald-700 dark:text-emerald-400 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ $t('اعتماد الاستقبال وتخصيص حافلة الوفد', 'Approuver & Navette', 'Approve & Assign Shuttle') }}</span>
                </h3>
                <button type="button" wire:click="$set('approveModalOpen', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>

            <div class="space-y-3 text-xs">
                <p class="text-slate-600 dark:text-slate-300 font-bold leading-relaxed">
                    {{ $t('اختر نوع وسيلة النقل الحافلة البروتوكولية المخصصة لاستقبال هذا الوفد عند الوصول للمطار:', 'Sélectionnez la navette officielle pour cette délégation :', 'Select official shuttle transport for this arrival:') }}
                </p>

                <div>
                    <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('وسيلة النقل / الحافلة البروتوكولية *', 'Navette Protocolaire *', 'Protocol Shuttle *') }}</label>
                    <select wire:model="selectedShuttle" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs">
                        <option value="حافلة بروتوكولية فاخرة (VIP Bus 01)">حافلة بروتوكولية فاخرة (VIP Bus 01)</option>
                        <option value="حافلة بروتوكولية فاخرة (VIP Bus 02)">حافلة بروتوكولية فاخرة (VIP Bus 02)</option>
                        <option value="ميني باص الوفود الرسمية (Minibus 05)">ميني باص الوفود الرسمية (Minibus 05)</option>
                        <option value="سيارات بروتوكولية وزارية (VIP Sedan Escort)">سيارات بروتوكولية وزارية (VIP Sedan Escort)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                <button type="button" wire:click="$set('approveModalOpen', false)" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">
                    {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                </button>
                <button type="button" wire:click="approveArrivalConfirmed" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md">
                    {{ $t('تأكيد الاعتماد والتخصيص', 'Confirmer Accueil', 'Confirm Approval') }}
                </button>
            </div>
        </div>
    </div>
    @endif

</div>
