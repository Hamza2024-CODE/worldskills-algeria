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

<div class="space-y-6 pb-12 print:p-0 print:m-0">

    {{-- PRINT ONLY EXECUTIVE HEADER --}}
    <div class="hidden print:block mb-8 border-b-2 border-slate-900 pb-4 text-center">
        <h1 class="text-2xl font-black text-slate-900">منصة مهارات الجزائر - التقرير الإحصائي والتنفيذي الرسمي</h1>
        <p class="text-sm text-slate-600 mt-1">تاريخ التقرير: {{ date('Y-m-d H:i') }} | المنصة الوطنية للمنافسات والمهارات</p>
    </div>

    {{-- TOP BANNER / HEADER --}}
    <div class="print:hidden relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#06205C] via-[#0A2E80] to-[#06205C] p-6 md:p-8 text-white shadow-xl border border-blue-900/40">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-400/30 text-amber-300 text-xs font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>{{ $t('لوحة الإحصائيات الوطنية والتحليلات Executive Analytics', 'Centre de Rapports Exécutifs', 'Executive Reports & Analytics Hub') }}</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight text-white">
                    {{ $t('التقارير والإحصائيات التجميعية الرسمية', 'Rapports Statistiques Officiels', 'Official Executive Reports & Analytics') }}
                </h1>
                <p class="text-xs md:text-sm text-blue-200/90 max-w-3xl leading-relaxed">
                    {{ $t('لوحة التحكم والإحصائيات الشاملة لمنصة مهارات الجزائر. متابعة دقيقة لمعدلات الإقبال والتوزيع الجغرافي وحالة الطلبات عبر كافة الطبعات والتخصصات.', 'Tableau de bord statistique complet pour la plateforme WorldSkills Algérie.', 'Comprehensive statistical and executive analytics dashboard for WorldSkills Algeria.') }}
                </p>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <button 
                    wire:click="exportReportsCsv" 
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg hover:shadow-amber-500/20 transition-all active:scale-95 cursor-pointer disabled:opacity-50"
                >
                    <svg wire:loading.remove wire:target="exportReportsCsv" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <svg wire:loading wire:target="exportReportsCsv" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>{{ $t('تصدير تقرير CSV', 'Exporter CSV', 'Export CSV Report') }}</span>
                </button>

                <button 
                    onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 shadow-md backdrop-blur-md transition-all active:scale-95 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>{{ $t('طباعة التقرير Executive Print', 'Imprimer le rapport', 'Print Report') }}</span>
                </button>
            </div>
        </div>
    </div>

    {{-- FILTER CONTROLS CARD --}}
    <div class="print:hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-5 shadow-sm space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/60 pb-3">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-700 dark:text-slate-300">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <span>{{ $t('خيارات تصفية الإحصائيات والتخصيص', 'Filtres de rapport', 'Report Filters & Customization') }}</span>
            </div>
            @if($selectedEdition !== 'all' || $selectedStatus !== 'all' || $dateFrom || $dateTo)
                <button 
                    wire:click="resetFilters" 
                    class="text-xs font-bold text-rose-600 dark:text-rose-400 hover:underline flex items-center gap-1 cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>{{ $t('إعادة ضبط الفلاتر', 'Réinitialiser', 'Reset Filters') }}</span>
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Edition Filter --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5">{{ $t('الطبعة الوطنية', 'Édition', 'Edition') }}</label>
                <select wire:model.live="selectedEdition" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="all">{{ $t('جميع الطبعات', 'Toutes les éditions', 'All Editions') }}</option>
                    @foreach($editionsList as $ed)
                        <option value="{{ $ed->id }}">{{ $ed->name_ar ?? $ed->name ?? ('طبعة ' . $ed->year) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Status Filter --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5">{{ $t('حالة الطلب', 'Statut', 'Status') }}</label>
                <select wire:model.live="selectedStatus" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="all">{{ $t('جميع الحالات', 'Tous les statuts', 'All Statuses') }}</option>
                    <option value="APPROVED">{{ $t('مقبول (APPROVED)', 'Approuvé', 'Approved') }}</option>
                    <option value="QUALIFIED_REGIONAL">{{ $t('متأهل إقليمياً (REGIONAL)', 'Qualifié Régional', 'Qualified Regional') }}</option>
                    <option value="QUALIFIED_NATIONAL">{{ $t('متأهل وطنياً (NATIONAL)', 'Qualifié National', 'Qualified National') }}</option>
                    <option value="PENDING">{{ $t('قيد الدراسة (PENDING)', 'En Attente', 'Pending') }}</option>
                    <option value="REJECTED">{{ $t('مرفوض (REJECTED)', 'Rejeté', 'Rejected') }}</option>
                </select>
            </div>

            {{-- Date From --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5">{{ $t('من تاريخ', 'De Date', 'From Date') }}</label>
                <input type="date" wire:model.live="dateFrom" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- Date To --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5">{{ $t('إلى تاريخ', 'À Date', 'To Date') }}</label>
                <input type="date" wire:model.live="dateTo" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
        </div>
    </div>

    {{-- PRIMARY TOP KPIS GRID --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- KPI 1: TOTAL REGISTRATIONS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-5 shadow-sm space-y-3 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-2 h-full bg-blue-600"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('إجمالي التسجيلات', 'Total Inscriptions', 'Total Registrations') }}</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white font-mono tracking-tight">
                {{ number_format($totalRegistrations) }}
            </div>
            <div class="flex flex-wrap items-center gap-1.5 pt-1 text-[11px] font-bold">
                <span class="px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400">{{ number_format($approvedRegs) }} {{ $t('مقبول', 'Approuvés', 'Approved') }}</span>
                <span class="px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400">{{ number_format($pendingRegs) }} {{ $t('قيد الدراسة', 'En attente', 'Pending') }}</span>
            </div>
        </div>

        {{-- KPI 2: TOTAL USERS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-5 shadow-sm space-y-3 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-2 h-full bg-emerald-500"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('الحسابات المسجلة', 'Comptes Utilisateurs', 'Registered Users') }}</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white font-mono tracking-tight">
                {{ number_format($totalUsers) }}
            </div>
            <p class="text-xs text-slate-400 font-medium pt-1">
                {{ $t('متنافسون، محكمون، خبراء ومسؤولون', 'Candidats, experts et juges', 'Competitors, experts & jury') }}
            </p>
        </div>

        {{-- KPI 3: TOTAL SKILLS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-5 shadow-sm space-y-3 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-2 h-full bg-purple-600"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('التخصصات الأولمبية', 'Compétences Olympiques', 'Skill Specializations') }}</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.428a2 2 0 00-1.022.547l-1.42 1.42a2 2 0 00-.547 1.022l-.477 2.387a2 2 0 002.409 2.409l2.387-.477a2 2 0 001.022-.547l1.42-1.42a2 2 0 00.547-1.022l.477-2.387a6 6 0 00-.517-3.86l-.158-.318a6 6 0 01-.517-3.86l.477-2.387a2 2 0 00-.547-1.022l-1.42-1.42a2 2 0 00-1.022-.547l-2.387.477a2 2 0 00-2.409 2.409l.477 2.387a2 2 0 00.547 1.022l1.42 1.42z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white font-mono tracking-tight">
                {{ number_format($totalSkills) }}
            </div>
            <p class="text-xs text-slate-400 font-medium pt-1">
                {{ $t('مهارة رسمية معتمدة دولياً ووطنياً', 'Compétences officielles homologuées', 'Official accredited skills') }}
            </p>
        </div>

        {{-- KPI 4: ORGANIZATIONS & WILAYAS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-5 shadow-sm space-y-3 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-2 h-full bg-cyan-600"></div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('المؤسسات والولايات', 'Institutions & Wilayas', 'Institutions & Wilayas') }}</span>
                <div class="w-8 h-8 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V7m0 0h4m-4 0H9"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 dark:text-white font-mono tracking-tight">
                {{ number_format($totalOrgs) }}
            </div>
            <div class="flex items-center gap-2 pt-1 text-xs font-bold text-cyan-600 dark:text-cyan-400">
                <span>{{ $totalWilayas }} {{ $t('ولاية مشاركة', 'Wilayas participantes', 'Participating Wilayas') }}</span>
            </div>
        </div>

    </div>

    {{-- REGISTRATION STATUS BREAKDOWN BAR --}}
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path></svg>
                <span>{{ $t('التوزيع المئوي لحالات طلبات التسجيل', 'Répartition des Inscriptions par Statut', 'Registration Status Breakdown') }}</span>
            </h3>
            <span class="text-xs font-bold text-slate-400 font-mono">{{ number_format($totalRegistrations) }} {{ $t('طلب إجمالي', 'Total', 'Total') }}</span>
        </div>

        {{-- VISUAL PROGRESS BAR --}}
        @php
            $pctApproved   = $totalRegistrations > 0 ? round(($approvedRegs / $totalRegistrations) * 100, 1) : 0;
            $pctQualReg    = $totalRegistrations > 0 ? round(($qualifiedRegRegs / $totalRegistrations) * 100, 1) : 0;
            $pctQualNat    = $totalRegistrations > 0 ? round(($qualifiedNatRegs / $totalRegistrations) * 100, 1) : 0;
            $pctPending    = $totalRegistrations > 0 ? round(($pendingRegs / $totalRegistrations) * 100, 1) : 0;
            $pctRejected   = $totalRegistrations > 0 ? round(($rejectedRegs / $totalRegistrations) * 100, 1) : 0;
        @endphp

        <div class="w-full h-4 bg-slate-100 dark:bg-slate-700/60 rounded-full overflow-hidden flex shadow-inner">
            @if($pctApproved > 0)
                <div class="bg-emerald-500 h-full transition-all duration-500" style="width: {{ $pctApproved }}%" title="مقبول {{ $pctApproved }}%"></div>
            @endif
            @if($pctQualReg > 0)
                <div class="bg-blue-500 h-full transition-all duration-500" style="width: {{ $pctQualReg }}%" title="متأهل إقليمي {{ $pctQualReg }}%"></div>
            @endif
            @if($pctQualNat > 0)
                <div class="bg-purple-600 h-full transition-all duration-500" style="width: {{ $pctQualNat }}%" title="متأهل وطني {{ $pctQualNat }}%"></div>
            @endif
            @if($pctPending > 0)
                <div class="bg-amber-400 h-full transition-all duration-500" style="width: {{ $pctPending }}%" title="قيد الدراسة {{ $pctPending }}%"></div>
            @endif
            @if($pctRejected > 0)
                <div class="bg-rose-500 h-full transition-all duration-500" style="width: {{ $pctRejected }}%" title="مرفوض {{ $pctRejected }}%"></div>
            @endif
        </div>

        {{-- LEGEND TILES --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 pt-2">
            <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/50">
                <div class="flex items-center justify-between text-xs font-bold text-emerald-800 dark:text-emerald-300 mb-1">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>{{ $t('مقبول APPROVED', 'Approuvé', 'Approved') }}</span>
                    </span>
                    <span class="font-mono">{{ $pctApproved }}%</span>
                </div>
                <div class="text-lg font-black text-emerald-900 dark:text-emerald-200 font-mono">{{ number_format($approvedRegs) }}</div>
            </div>

            <div class="p-3 rounded-xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/50">
                <div class="flex items-center justify-between text-xs font-bold text-blue-800 dark:text-blue-300 mb-1">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <span>{{ $t('متأهل إقليمياً', 'Qualifié Régional', 'Qualified Reg.') }}</span>
                    </span>
                    <span class="font-mono">{{ $pctQualReg }}%</span>
                </div>
                <div class="text-lg font-black text-blue-900 dark:text-blue-200 font-mono">{{ number_format($qualifiedRegRegs) }}</div>
            </div>

            <div class="p-3 rounded-xl bg-purple-50 dark:bg-purple-950/40 border border-purple-200 dark:border-purple-800/50">
                <div class="flex items-center justify-between text-xs font-bold text-purple-800 dark:text-purple-300 mb-1">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span>
                        <span>{{ $t('متأهل وطنياً', 'Qualifié National', 'Qualified Nat.') }}</span>
                    </span>
                    <span class="font-mono">{{ $pctQualNat }}%</span>
                </div>
                <div class="text-lg font-black text-purple-900 dark:text-purple-200 font-mono">{{ number_format($qualifiedNatRegs) }}</div>
            </div>

            <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/50">
                <div class="flex items-center justify-between text-xs font-bold text-amber-800 dark:text-amber-300 mb-1">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                        <span>{{ $t('قيد الدراسة', 'En Attente', 'Pending') }}</span>
                    </span>
                    <span class="font-mono">{{ $pctPending }}%</span>
                </div>
                <div class="text-lg font-black text-amber-900 dark:text-amber-200 font-mono">{{ number_format($pendingRegs) }}</div>
            </div>

            <div class="p-3 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/50">
                <div class="flex items-center justify-between text-xs font-bold text-rose-800 dark:text-rose-300 mb-1">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        <span>{{ $t('مرفوض REJECTED', 'Rejeté', 'Rejected') }}</span>
                    </span>
                    <span class="font-mono">{{ $pctRejected }}%</span>
                </div>
                <div class="text-lg font-black text-rose-900 dark:text-rose-200 font-mono">{{ number_format($rejectedRegs) }}</div>
            </div>
        </div>
    </div>

    {{-- STATISTICAL BREAKDOWNS (TOP WILAYAS & TOP SKILLS) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- TOP WILAYAS CARD --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-6 space-y-5 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-base text-slate-900 dark:text-white">
                            {{ $t('أعلى الولايات تسجيلًا (التوزيع الجغرافي)', 'Top Wilayas par Inscriptions', 'Top Wilayas by Registrations') }}
                        </h3>
                        <p class="text-xs text-slate-400 font-medium">
                            {{ $t('ترتيب الولايات الـ 12 الأكثر إقبالاً ونشاطاً', 'Classement des 12 premières wilayas', 'Ranking of top 12 active wilayas') }}
                        </p>
                    </div>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-mono">
                    Top 12
                </span>
            </div>

            <div class="space-y-3.5">
                @forelse($topWilayas as $index => $w)
                    @php
                        $pctW = $totalRegistrations > 0 ? min(100, round(($w->registrations_count / $totalRegistrations) * 100, 1)) : 0;
                    @endphp
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-md text-[11px] font-mono font-bold flex items-center justify-center {{ $index < 3 ? 'bg-amber-500 text-slate-950' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300' }}">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-bold text-slate-800 dark:text-slate-200">
                                    {{ sprintf('%02d', $w->code ?? $w->id) }} — {{ $w->name_ar ?? $w->name }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 font-mono text-xs">
                                <span class="text-slate-400 font-medium">{{ $pctW }}%</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($w->registrations_count) }} {{ $t('مسجل', 'inscrits', 'registered') }}</span>
                            </div>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-700/60 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-600 to-teal-400 h-2 rounded-full transition-all duration-500" style="width: {{ $pctW }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-slate-400">
                        {{ $t('لا توجد بيانات تسجيلات متاحة حالياً', 'Aucune donnée disponible', 'No registration data available') }}
                    </div>
                @endforelse
            </div>
        </div>

        {{-- TOP SKILLS CARD --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-6 space-y-5 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-purple-100 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-base text-slate-900 dark:text-white">
                            {{ $t('أعلى التخصصات الأولمبية إقبالاً', 'Top Métiers & Compétences', 'Top Olympic Skills') }}
                        </h3>
                        <p class="text-xs text-slate-400 font-medium">
                            {{ $t('ترتيب التخصصات الـ 12 الأكثر طلباً من قبل المترشحين', 'Classement des 12 métiers les plus demandés', 'Ranking of top 12 most requested skills') }}
                        </p>
                    </div>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-mono">
                    Top 12
                </span>
            </div>

            <div class="space-y-3.5">
                @forelse($topSkills as $index => $s)
                    @php
                        $pctS = $totalRegistrations > 0 ? min(100, round(($s->registrations_count / $totalRegistrations) * 100, 1)) : 0;
                    @endphp
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-md text-[11px] font-mono font-bold flex items-center justify-center {{ $index < 3 ? 'bg-purple-600 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300' }}">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-bold text-slate-800 dark:text-slate-200 line-clamp-1">
                                    {{ $s->name_ar ?? $s->name }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 font-mono text-xs shrink-0">
                                <span class="text-slate-400 font-medium">{{ $pctS }}%</span>
                                <span class="font-bold text-purple-600 dark:text-purple-400">{{ number_format($s->registrations_count) }} {{ $t('متنافس', 'candidats', 'competitors') }}</span>
                            </div>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-700/60 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-600 to-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $pctS }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-slate-400">
                        {{ $t('لا توجد بيانات تخصصات متاحة حالياً', 'Aucune donnée disponible', 'No skill data available') }}
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- RECENT REGISTRATION STREAM TABLE --}}
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-black text-base text-slate-900 dark:text-white">
                        {{ $t('أحدث عمليات التسجيل في المنصة', 'Dernières inscriptions', 'Recent Registrations Stream') }}
                    </h3>
                    <p class="text-xs text-slate-400 font-medium">
                        {{ $t('سجل مباشرة لآخر الطلبات المقدمة عبر البوابة الرسمية', 'Flux en direct des dernières demandes', 'Live stream of latest submitted applications') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700">
                        <th class="p-3 rounded-r-xl">{{ $t('رقم التسجيل', 'N° Inscription', 'Reg Number') }}</th>
                        <th class="p-3">{{ $t('المترشح / المشارك', 'Participant', 'Participant') }}</th>
                        <th class="p-3">{{ $t('التخصص المظلي', 'Métier', 'Skill Specialization') }}</th>
                        <th class="p-3">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                        <th class="p-3 rounded-l-xl">{{ $t('تاريخ التقديم', 'Date', 'Submitted Date') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse($recentRegistrations as $reg)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="p-3 font-mono font-bold text-blue-600 dark:text-blue-400">
                                {{ $reg->registration_number ?? ('#WS-' . $reg->id) }}
                            </td>
                            <td class="p-3 font-bold text-slate-800 dark:text-slate-200">
                                {{ $reg->participant->name ?? $t('مشارك إلكتروني', 'Participant', 'Online Participant') }}
                            </td>
                            <td class="p-3 text-slate-600 dark:text-slate-400 font-medium">
                                {{ $reg->skill->name_ar ?? $reg->skill->name ?? '—' }}
                            </td>
                            <td class="p-3">
                                @php
                                    $statusBadge = match($reg->status) {
                                        'APPROVED' => ['bg' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300', 'label' => $t('مقبول', 'Approuvé', 'Approved')],
                                        'QUALIFIED_REGIONAL' => ['bg' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300', 'label' => $t('متأهل إقليمي', 'Qualifié Régional', 'Qualified Reg.')],
                                        'QUALIFIED_NATIONAL' => ['bg' => 'bg-purple-100 text-purple-800 dark:bg-purple-950/60 dark:text-purple-300', 'label' => $t('متأهل وطني', 'Qualifié National', 'Qualified Nat.')],
                                        'PENDING' => ['bg' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300', 'label' => $t('قيد الدراسة', 'En Attente', 'Pending')],
                                        'REJECTED' => ['bg' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300', 'label' => $t('مرفوض', 'Rejeté', 'Rejected')],
                                        default => ['bg' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300', 'label' => $reg->status],
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold inline-block {{ $statusBadge['bg'] }}">
                                    {{ $statusBadge['label'] }}
                                </span>
                            </td>
                            <td class="p-3 text-slate-500 font-mono text-[11px]">
                                {{ $reg->created_at ? $reg->created_at->format('Y-m-d H:i') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-xs text-slate-400">
                                {{ $t('لا توجد سجلات أحدث حالياً', 'Aucun enregistrement récent', 'No recent records found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
