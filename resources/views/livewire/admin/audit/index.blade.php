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

<div class="space-y-6 pb-12 print:p-0 print:m-0" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- PRINT ONLY EXECUTIVE HEADER --}}
    <div class="hidden print:block mb-8 border-b-2 border-slate-900 pb-4 text-center">
        <h1 class="text-2xl font-black text-slate-900">منصة مهارات الجزائر - سجل التدقيق والتفتيش الأمني الرسمي</h1>
        <p class="text-sm text-slate-600 mt-1">تاريخ التقرير الأمني: {{ date('Y-m-d H:i:s') }} | السجلات والأحداث الأمنية</p>
    </div>

    {{-- TOP BANNER / HEADER --}}
    <div class="print:hidden relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#06205C] via-[#0A2E80] to-[#06205C] p-6 md:p-8 text-white shadow-xl border border-blue-900/40">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-400/30 text-amber-300 text-xs font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>{{ $t('نظام الرقابة والأمان السحابي Security Audit & Oversight', 'Système d\'Audit et Sécurité', 'Security & Compliance Audit Center') }}</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight text-white">
                    {{ $t('سجلات التدقيق الأمني والعمليات الحية', 'Journal d\'Audit et Sécurité en Direct', 'Live Security & Operations Audit Trail') }}
                </h1>
                <p class="text-xs md:text-sm text-blue-200/90 max-w-3xl leading-relaxed">
                    {{ $t('متابعة وتوثيق كافة التغييرات وحركات الدخول وتغيير الإعدادات والتجاوزات الاستثنائية لضمان أعلى مستويات الأمان والشفافية في منصة مهارات الجزائر.', 'Suivi en temps réel des actions de sécurité, accès et modifications système.', 'Real-time audit tracking for access control, emergency overrides, and system setting changes.') }}
                </p>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <button 
                    wire:click="exportCsv" 
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg hover:shadow-amber-500/20 transition-all active:scale-95 cursor-pointer disabled:opacity-50"
                >
                    <svg wire:loading.remove wire:target="exportCsv" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <svg wire:loading wire:target="exportCsv" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>{{ $t('تصدير سجلات CSV', 'Exporter CSV', 'Export Audit CSV') }}</span>
                </button>

                <button 
                    onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 shadow-md backdrop-blur-md transition-all active:scale-95 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>{{ $t('طباعة السجل Security Print', 'Imprimer le journal', 'Print Log') }}</span>
                </button>
            </div>
        </div>
    </div>

    {{-- STATS KPIS GRID --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        
        {{-- TOTAL LOGS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-4 shadow-sm space-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1.5 h-full bg-blue-600"></div>
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block">{{ $t('إجمالي الأحداث', 'Total الإثباتات', 'Total Logs') }}</span>
            <div class="text-2xl font-black text-slate-900 dark:text-white font-mono tracking-tight">
                {{ number_format($totalLogs) }}
            </div>
            <span class="text-[10px] text-slate-400 font-medium block">{{ $t('عملية أمان موثقة', 'événements enregistrés', 'logged events') }}</span>
        </div>

        {{-- ACCESS ALLOW --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-4 shadow-sm space-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1.5 h-full bg-emerald-500"></div>
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block">{{ $t('سماح بالدخول', 'Accès Autorisés', 'Access Allowed') }}</span>
            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 font-mono tracking-tight">
                {{ number_format($allowCount) }}
            </div>
            <span class="text-[10px] text-emerald-600/80 font-bold block">ACCESS_ALLOW</span>
        </div>

        {{-- ACCESS DENY --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-4 shadow-sm space-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1.5 h-full bg-rose-500"></div>
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block">{{ $t('محاولات مرفوضة', 'Accès Refusés', 'Access Denied') }}</span>
            <div class="text-2xl font-black text-rose-600 dark:text-rose-400 font-mono tracking-tight">
                {{ number_format($denyCount) }}
            </div>
            <span class="text-[10px] text-rose-600/80 font-bold block">ACCESS_DENY</span>
        </div>

        {{-- EMERGENCY OVERRIDE --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-4 shadow-sm space-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1.5 h-full bg-purple-600"></div>
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block">{{ $t('تجاوزات استثنائية', 'Dérogations', 'Overrides') }}</span>
            <div class="text-2xl font-black text-purple-600 dark:text-purple-400 font-mono tracking-tight">
                {{ number_format($overrideCount) }}
            </div>
            <span class="text-[10px] text-purple-600/80 font-bold block">OVERRIDE</span>
        </div>

        {{-- SETTING UPDATED --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-4 shadow-sm space-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1.5 h-full bg-cyan-600"></div>
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block">{{ $t('تحديث الإعدادات', 'Paramètres', 'Settings Change') }}</span>
            <div class="text-2xl font-black text-slate-900 dark:text-white font-mono tracking-tight">
                {{ number_format($settingCount) }}
            </div>
            <span class="text-[10px] text-cyan-600/80 font-bold block">SETTING_UPDATED</span>
        </div>

        {{-- TODAY LOGS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-4 shadow-sm space-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1.5 h-full bg-amber-500"></div>
            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block">{{ $t('سجلات اليوم', 'Aujourd\'hui', 'Logs Today') }}</span>
            <div class="text-2xl font-black text-amber-600 dark:text-amber-400 font-mono tracking-tight">
                {{ number_format($todayCount) }}
            </div>
            <span class="text-[10px] text-amber-600/80 font-bold block">{{ date('Y-m-d') }}</span>
        </div>

    </div>

    {{-- FILTERS CARD --}}
    <div class="print:hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-4 shadow-sm space-y-3">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/60 pb-2.5">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-700 dark:text-slate-300">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <span>{{ $t('خيارات الفلترة والتنقيب في سجلات الأمان', 'Filtres de recherche', 'Search & Audit Filters') }}</span>
            </div>
            @if($search || $filterEvent || $dateFrom || $dateTo)
                <button 
                    wire:click="resetFilters" 
                    class="text-xs font-bold text-rose-600 dark:text-rose-400 hover:underline flex items-center gap-1 cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>{{ $t('إعادة ضبط', 'Réinitialiser', 'Reset') }}</span>
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            {{-- SEARCH --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1">{{ $t('كلمة البحث', 'Rechercher', 'Search Query') }}</label>
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="text" 
                    placeholder="{{ $t('بحث بالحدث، المستخدم، IP...', 'Rechercher par événement, IP...', 'Search event, IP, user...') }}"
                    class="w-full px-3 py-2 text-xs font-medium rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            {{-- EVENT TYPE --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1">{{ $t('نوع الحدث', 'Type d\'événement', 'Event Type') }}</label>
                <select 
                    wire:model.live="filterEvent"
                    class="w-full px-3 py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                    <option value="">{{ $t('جميع الأحداث الأمنيّة', 'Tous les événements', 'All Security Events') }}</option>
                    @foreach($events as $ev)
                        <option value="{{ $ev }}">{{ $ev }}</option>
                    @endforeach
                </select>
            </div>

            {{-- DATE FROM --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1">{{ $t('من تاريخ', 'De date', 'From date') }}</label>
                <input 
                    type="date" 
                    wire:model.live="dateFrom" 
                    class="w-full px-3 py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            {{-- DATE TO --}}
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1">{{ $t('إلى تاريخ', 'À date', 'To date') }}</label>
                <input 
                    type="date" 
                    wire:model.live="dateTo" 
                    class="w-full px-3 py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
        </div>
    </div>

    {{-- AUDIT LOGS TABLE --}}
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700">
                        <th class="p-3.5 rounded-r-xl w-16 text-center">#</th>
                        <th class="p-3.5">{{ $t('الحدث / العملية الأمنية', 'Événement', 'Event / Action') }}</th>
                        <th class="p-3.5">{{ $t('المستخدم المنفذ', 'Utilisateur', 'User') }}</th>
                        <th class="p-3.5">{{ $t('عنوان IP', 'Adresse IP', 'IP Address') }}</th>
                        <th class="p-3.5">{{ $t('الهدف (Subject)', 'Cible', 'Subject Target') }}</th>
                        <th class="p-3.5">{{ $t('التاريخ والوقت', 'Date & Heure', 'Date & Time') }}</th>
                        <th class="p-3.5 rounded-l-xl text-left">{{ $t('التفاصيل', 'Détails', 'Details') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-700/30 transition-colors">
                            {{-- ID --}}
                            <td class="p-3.5 text-center font-mono font-bold text-slate-400">
                                #{{ $log->id }}
                            </td>

                            {{-- EVENT BADGE --}}
                            <td class="p-3.5">
                                @php
                                    $evBadge = match(true) {
                                        str_contains($log->event, 'ALLOW') => ['bg' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border-emerald-300'],
                                        str_contains($log->event, 'DENY') => ['bg' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300 border-rose-300'],
                                        str_contains($log->event, 'OVERRIDE') => ['bg' => 'bg-purple-100 text-purple-800 dark:bg-purple-950/60 dark:text-purple-300 border-purple-300'],
                                        str_contains($log->event, 'SETTING') => ['bg' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300 border-blue-300'],
                                        default => ['bg' => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200 border-slate-300'],
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-mono font-black inline-flex items-center gap-1 border {{ $evBadge['bg'] }}">
                                    @if(str_contains($log->event, 'OVERRIDE'))
                                        <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    @endif
                                    <span>{{ $log->event }}</span>
                                </span>
                            </td>

                            {{-- USER --}}
                            <td class="p-3.5">
                                @if($log->user)
                                    <div class="font-bold text-slate-900 dark:text-white">
                                        {{ $log->user->name }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 font-mono">
                                        {{ $log->user->email }}
                                    </div>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-500 font-bold text-[11px]">
                                        {{ $t('زائر / نظام تلقائي', 'Système / Invité', 'System / Guest') }}
                                    </span>
                                @endif
                            </td>

                            {{-- IP ADDRESS --}}
                            <td class="p-3.5 font-mono text-xs text-slate-600 dark:text-slate-300">
                                <span class="px-2 py-0.5 rounded-md bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                                    {{ $log->ip_address ?? '127.0.0.1' }}
                                </span>
                            </td>

                            {{-- SUBJECT TARGET --}}
                            <td class="p-3.5 font-mono text-[11px] text-slate-500 dark:text-slate-400">
                                @if($log->subject_type)
                                    <span class="font-bold text-slate-700 dark:text-slate-300">{{ class_basename($log->subject_type) }}</span>
                                    @if($log->subject_id)
                                        <span class="text-blue-600 dark:text-blue-400">#{{ $log->subject_id }}</span>
                                    @endif
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>

                            {{-- TIMESTAMP --}}
                            <td class="p-3.5 font-mono text-[11px] text-slate-500 dark:text-slate-400">
                                {{ $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : '—' }}
                            </td>

                            {{-- ACTIONS --}}
                            <td class="p-3.5 text-left">
                                <button 
                                    wire:click="openDrawer({{ $log->id }})" 
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 text-slate-700 dark:text-slate-200 font-bold text-xs transition-all cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <span>{{ $t('عرض التفاصيل', 'Détails', 'View') }}</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-slate-400">
                                {{ $t('لا توجد سجلات أمان مسجلة تطابق شروط البحث', 'Aucun enregistrement d\'audit trouvé', 'No audit logs found matching criteria') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700/60">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    {{-- DETAIL DRAWER --}}
    @if($drawerOpen && $selectedLog)
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-950/60 backdrop-blur-xs">
            <div class="w-full max-w-lg bg-white dark:bg-slate-800 border-s border-slate-200 dark:border-slate-700 h-full p-6 overflow-y-auto space-y-6 shadow-2xl">
                
                {{-- DRAWER HEADER --}}
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <span class="text-xs font-mono font-bold text-slate-400">Audit Log #{{ $selectedLog->id }}</span>
                        <h2 class="text-lg font-black text-slate-900 dark:text-white mt-1">{{ $selectedLog->event }}</h2>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- DRAWER CONTENT --}}
                <div class="space-y-4 text-xs">
                    
                    {{-- USER & TIME CARD --}}
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 space-y-2.5">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">{{ $t('المستخدم المنفذ', 'Utilisateur', 'User') }}:</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedLog->user?->name ?? 'زائر / نظام' }}</span>
                        </div>
                        @if($selectedLog->user?->email)
                            <div class="flex justify-between">
                                <span class="text-slate-400 font-medium">{{ $t('البريد الإلكتروني', 'Email', 'Email') }}:</span>
                                <span class="font-mono text-slate-700 dark:text-slate-300">{{ $selectedLog->user->email }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">{{ $t('عنوان IP', 'IP', 'IP Address') }}:</span>
                            <span class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $selectedLog->ip_address ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">{{ $t('الوقت والتاريخ', 'Date', 'Timestamp') }}:</span>
                            <span class="font-mono text-slate-700 dark:text-slate-300">{{ $selectedLog->created_at ? $selectedLog->created_at->format('Y-m-d H:i:s') : '—' }}</span>
                        </div>
                    </div>

                    {{-- TARGET SUBJECT CARD --}}
                    @if($selectedLog->subject_type)
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 space-y-2">
                            <span class="text-[11px] font-bold text-slate-400 block">{{ $t('الكائن المستهدف (Subject Target)', 'Objet Cible', 'Target Subject') }}</span>
                            <div class="flex justify-between font-mono">
                                <span class="text-slate-500">Type:</span>
                                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedLog->subject_type }}</span>
                            </div>
                            <div class="flex justify-between font-mono">
                                <span class="text-slate-500">ID:</span>
                                <span class="font-bold text-blue-600">#{{ $selectedLog->subject_id }}</span>
                            </div>
                        </div>
                    @endif

                    {{-- USER AGENT --}}
                    @if($selectedLog->user_agent)
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 space-y-1.5">
                            <span class="text-[11px] font-bold text-slate-400 block">User Agent (المتصفح والنظام)</span>
                            <p class="font-mono text-[11px] text-slate-600 dark:text-slate-400 break-all leading-relaxed">
                                {{ $selectedLog->user_agent }}
                            </p>
                        </div>
                    @endif

                    {{-- METADATA JSON VIEWER --}}
                    @if($selectedLog->metadata)
                        <div class="p-4 rounded-2xl bg-slate-900 text-slate-100 space-y-2 font-mono">
                            <span class="text-[11px] font-bold text-amber-400 block">{{ $t('البيانات الإضافية (Metadata JSON)', 'Métadonnées', 'Metadata JSON Payload') }}</span>
                            <pre class="text-[11px] overflow-x-auto whitespace-pre-wrap p-3 rounded-xl bg-slate-950 border border-slate-800 text-emerald-400 max-h-60">
{{ json_encode($selectedLog->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                            </pre>
                        </div>
                    @endif

                </div>

                {{-- DRAWER FOOTER --}}
                <div class="pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button 
                        wire:click="$set('drawerOpen', false)" 
                        class="w-full py-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 rounded-xl transition-all cursor-pointer"
                    >
                        {{ $t('إغلاق التفاصيل', 'Fermer', 'Close Details') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
