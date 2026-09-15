@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-700 pb-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#06205C] to-blue-900 text-white flex items-center justify-center font-bold shadow-md">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        {{ $t('لوحة إحصائيات ونسب المباحثات الوزارية', 'Tableau de Bord des Entretiens Ministériels', 'Ministerial Meetings Statistics Dashboard') }}
                    </h1>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5">
                        {{ $t('متابعة حية ونسب مئوية دقيقة لجلسات المباحثات الثنائية واللقاءات البروتوكولية المحجوزة.', 'Suivi en temps réel des statistiques et taux de réalisation des entretiens bilatéraux.', 'Real-time tracking of bilateral meeting metrics and completion rates.') }}
                    </p>
                </div>
            </div>
        </div>

        <a href="{{ route('executive.diplomatic') }}" class="px-5 py-2.5 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs transition shadow-md flex items-center gap-2 self-start sm:self-auto border border-blue-900">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $t('حجز لقاء جديد', 'Nouveau Créneau', 'Book New Talk') }}</span>
        </a>
    </div>

    <!-- KPI Metric Cards (Focused ONLY on Meetings & Percentages) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Meetings -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-black text-slate-400 dark:text-slate-400 uppercase tracking-wider">{{ $t('إجمالي المباحثات', 'Total Entretiens', 'Total Meetings') }}</p>
                <p class="text-2xl font-black text-[#06205C] dark:text-white mt-1">{{ number_format($totalMeetings) }}</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-800 dark:bg-blue-950 dark:text-blue-200 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <!-- Completion Rate Percentage -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-black text-slate-400 dark:text-slate-400 uppercase tracking-wider">{{ $t('نسبة المباحثات المكتملة', 'Taux d\'Entretiens Terminés', 'Completion Rate') }}</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $completionPercentage }}%</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- Scheduled Meetings Percentage -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-black text-slate-400 dark:text-slate-400 uppercase tracking-wider">{{ $t('نسبة الجلسات المجدولة', 'Taux d\'Entretiens Programmés', 'Scheduled Rate') }}</p>
                <p class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1">{{ $scheduledPercentage }}%</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-300 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- In-Progress Meetings -->
        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-black text-slate-400 dark:text-slate-400 uppercase tracking-wider">{{ $t('المباحثات الجارية حالياً', 'En Session Directe', 'In Session Now') }}</p>
                <p class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1">{{ number_format($inProgressMeetings) }}</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-700 dark:bg-purple-950 dark:text-purple-300 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>

    </div>

    <!-- Visual Progress Breakdown Card -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-md space-y-4">
        <h3 class="text-sm font-black text-[#06205C] dark:text-white uppercase tracking-wider">
            {{ $t('التوزيع المئوي لحالة المباحثات الثنائية:', 'Répartition en pourcentage des entretiens:', 'Percentage Breakdown of Bilateral Talks:') }}
        </h3>

        <div class="space-y-4">
            <!-- Progress 1: Scheduled -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between text-xs font-bold">
                    <span class="text-slate-700 dark:text-slate-300 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <span>{{ $t('مباحثات مجدولة ومثبتة (SCHEDULED)', 'Entretiens Programmés', 'Scheduled Meetings') }}</span>
                    </span>
                    <span class="text-amber-600 dark:text-amber-400 font-mono">{{ $scheduledMeetings }} ({{ $scheduledPercentage }}%)</span>
                </div>
                <div class="w-full h-3 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                    <div class="h-full bg-amber-500 rounded-full transition-all duration-500" style="width: {{ $scheduledPercentage }}%"></div>
                </div>
            </div>

            <!-- Progress 2: Completed -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between text-xs font-bold">
                    <span class="text-slate-700 dark:text-slate-300 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>{{ $t('مباحثات مكتملة بنجاح (COMPLETED)', 'Entretiens Terminés', 'Completed Meetings') }}</span>
                    </span>
                    <span class="text-emerald-600 dark:text-emerald-400 font-mono">{{ $completedMeetings }} ({{ $completionPercentage }}%)</span>
                </div>
                <div class="w-full h-3 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $completionPercentage }}%"></div>
                </div>
            </div>

            <!-- Progress 3: In Progress -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between text-xs font-bold">
                    <span class="text-slate-700 dark:text-slate-300 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500 animate-ping"></span>
                        <span>{{ $t('مباحثات جارية في القاعات (IN_PROGRESS)', 'En Cours', 'In Progress') }}</span>
                    </span>
                    <span class="text-purple-600 dark:text-purple-400 font-mono">{{ $inProgressMeetings }} ({{ $inProgressPercentage }}%)</span>
                </div>
                <div class="w-full h-3 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-500 rounded-full transition-all duration-500" style="width: {{ $inProgressPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Bilateral Talks Roster -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-md overflow-hidden space-y-0">
        <div class="p-5 bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h3 class="text-sm font-black text-[#06205C] dark:text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $t('جدول جلسات المباحثات الوزارية الخاصة بك', 'Vos Entretiens Bilatéraux', 'Your Bilateral Talks Roster') }}</span>
            </h3>

            <select wire:model.live="selectedStatus" class="px-3 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white">
                <option value="ALL">{{ $t('جميع الحالات', 'Tous les statuts', 'All Statuses') }}</option>
                <option value="SCHEDULED">{{ $t('مجدول ومثبت (SCHEDULED)', 'Programmé', 'Scheduled') }}</option>
                <option value="IN_PROGRESS">{{ $t('جاري الآن (IN_PROGRESS)', 'En cours', 'In Progress') }}</option>
                <option value="COMPLETED">{{ $t('مكتمل (COMPLETED)', 'Terminé', 'Completed') }}</option>
            </select>
        </div>

        <div class="divide-y divide-slate-100 dark:divide-slate-700">
            @forelse($meetings as $mtg)
                <div class="p-5 hover:bg-slate-50/70 dark:hover:bg-slate-700/40 transition flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="space-y-1.5 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-black bg-blue-50 text-blue-800 dark:bg-blue-950 dark:text-blue-200 border border-blue-200 dark:border-blue-900">
                                {{ $mtg->start_time->format('Y-m-d H:i') }} — {{ $mtg->end_time->format('H:i') }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase
                                {{ $mtg->status === 'SCHEDULED' ? 'bg-amber-50 text-amber-900 border border-amber-300' : ($mtg->status === 'IN_PROGRESS' ? 'bg-emerald-50 text-emerald-900 border border-emerald-300 animate-pulse' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                                {{ $mtg->status }}
                            </span>
                        </div>

                        <h4 class="text-base font-black text-[#06205C] dark:text-white leading-tight">
                            {{ $mtg->title }}
                        </h4>

                        <div class="flex flex-wrap items-center gap-3 text-xs font-bold text-slate-600 dark:text-slate-400 pt-1">
                            <span class="text-blue-700 dark:text-blue-400"><x-ws.icon name="user" class="w-3.5 h-3.5 inline-block me-1" /> {{ $mtg->hostMinister?->full_name }} ({{ $mtg->hostMinister?->country?->code ?? 'DZA' }})</span>
                            <span>↔</span>
                            <span class="text-amber-700 dark:text-amber-400"><x-ws.icon name="user" class="w-3.5 h-3.5 inline-block me-1" /> {{ $mtg->guestMinister?->full_name }} ({{ $mtg->guestMinister?->country?->code ?? 'DZA' }})</span>
                            <span class="text-slate-400">| <x-ws.icon name="building-library" class="w-3.5 h-3.5 inline-block me-1" /> {{ $mtg->room?->getLocalized('name') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-xs font-bold text-slate-400">
                    {{ $t('لا توجد مباحثات مطابقة لهذا الفلتر حالياً', 'Aucun entretien trouvé', 'No meetings found') }}
                </div>
            @endforelse
        </div>
    </div>

</div>
