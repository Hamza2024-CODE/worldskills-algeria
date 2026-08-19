@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 pb-16" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    <div class="printable-hide-on-print space-y-8">

        {{-- ── 1. UNIFIED LUXURY PAGE HEADER ── --}}
        <x-dashboard.page-header
            :title="$t('مركز القيادة الدبلوماسية والتبادل الوزاري والثقافي', 'Centre de Commandement Diplomatique & Échanges Ministériels', 'Diplomatic Command Center & Ministerial Exchange')"
            :subtitle="$t('منظومة حجز القاعات الدبلوماسية، الجدولة الثنائية وتتبع جاهزية الوزراء والوفود الرسمية', 'Réservation des salons VIP, entretiens bilatéraux et suivi de disponibilité ministérielle', 'VIP lounge booking, bilateral meeting scheduling, and official minister availability tracking')"
        >
            <button wire:click="$set('showAddMinisterModal', true)" class="px-5 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs backdrop-blur-md transition flex items-center gap-2 shadow-sm shrink-0">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span>{{ $t('إضافة مسؤول وزاري', 'Ajouter Ministre', 'Add Minister') }}</span>
            </button>

            <button wire:click="openBookingModal" class="px-5 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-lg transition flex items-center gap-2 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $t('حجز لقاء ثنائي وقاعة', 'Nouveau Rendez-vous', 'New Bilateral Meeting') }}</span>
            </button>
        </x-dashboard.page-header>

        {{-- FLASH / ERROR NOTIFICATIONS --}}
        @if($flashMessage)
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 text-xs font-black flex items-center justify-between shadow-xs animate-fade-in">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $flashMessage }}</span>
                </div>
                <button wire:click="$set('flashMessage', '')" class="text-emerald-700 dark:text-emerald-400 font-black text-xs hover:opacity-75">✕</button>
            </div>
        @endif

        {{-- ── 2. EXECUTIVE DIPLOMATIC KPI CARDS ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            {{-- KPI 1 --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:border-blue-500/50 transition">
                <div class="flex items-center justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-[11px] font-black text-slate-400 dark:text-slate-400 uppercase tracking-wider block">
                            {{ $t('الوزراء والمسؤولون', 'Ministres & Officiels', 'Ministers & Officials') }}
                        </span>
                        <p class="text-3xl font-black text-[#06205C] dark:text-white">{{ $totalMinistersCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black shrink-0 border border-blue-100 dark:border-blue-800 shadow-inner group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-[11px] font-bold text-slate-500 dark:text-slate-400">
                    <span>{{ $t('وفود رسمية معتمدة', 'Délégations Homologuées', 'Accredited Delegations') }}</span>
                    <span class="text-blue-600 dark:text-blue-400 font-mono font-black">100%</span>
                </div>
            </div>

            {{-- KPI 2 --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:border-emerald-500/50 transition">
                <div class="flex items-center justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-[11px] font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-wider block">
                            {{ $t('متاحون للعمل واللقاءات', 'Disponible pour entretiens', 'Available for Meetings') }}
                        </span>
                        <p class="text-3xl font-black text-emerald-900 dark:text-emerald-200">{{ $availableMinistersCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black shrink-0 border border-emerald-100 dark:border-emerald-800 shadow-inner group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-[11px] font-bold text-emerald-700 dark:text-emerald-400">
                    <span>{{ $t('حالة التوافر المباشرة', 'Statut en Temps Réel', 'Real-time Status') }}</span>
                    <span class="flex items-center gap-1 font-mono font-black">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        {{ $t('جاهز', 'Actif', 'Active') }}
                    </span>
                </div>
            </div>

            {{-- KPI 3 --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:border-amber-500/50 transition">
                <div class="flex items-center justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-[11px] font-black text-amber-700 dark:text-amber-400 uppercase tracking-wider block">
                            {{ $t('لقاءات ثنائية مجدولة', 'Rencontres Mainties', 'Scheduled Meetings') }}
                        </span>
                        <p class="text-3xl font-black text-amber-900 dark:text-amber-200">{{ $scheduledMeetingsCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black shrink-0 border border-amber-100 dark:border-amber-800 shadow-inner group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-[11px] font-bold text-amber-700 dark:text-amber-400">
                    <span>{{ $t('البرنامج الحكومي الثنائي', 'Programme Ministériel', 'Ministerial Agenda') }}</span>
                    <span class="font-mono font-black">2026</span>
                </div>
            </div>

            {{-- KPI 4 --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:border-purple-500/50 transition">
                <div class="flex items-center justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-[11px] font-black text-purple-700 dark:text-purple-400 uppercase tracking-wider block">
                            {{ $t('قاعات اجتماعات VIP جاهزة', 'Salons VIP Prêts', 'Ready VIP Lounges') }}
                        </span>
                        <p class="text-3xl font-black text-purple-900 dark:text-purple-200">{{ $activeRoomsCount }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center font-black shrink-0 border border-purple-100 dark:border-purple-800 shadow-inner group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-[11px] font-bold text-purple-700 dark:text-purple-400">
                    <span>{{ $t('مستويات الأمان والبروتوكول', 'Niveau de Sécurité', 'Security & Protocol') }}</span>
                    <span class="font-mono font-black text-emerald-500">HIGH</span>
                </div>
            </div>

        </div>

        {{-- ── 3. NAVIGATION TABS BAR ── --}}
        <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-3 flex-wrap">
            <button wire:click="$set('activeTab', 'MEETINGS')"
                    class="px-5 py-3 rounded-2xl font-black text-xs transition flex items-center gap-2.5 shadow-sm {{ $activeTab === 'MEETINGS' ? 'bg-[#06205C] text-white shadow-md ring-2 ring-blue-500/30' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 border border-slate-200/80 dark:border-slate-700' }}">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $t('جدول اللقاءات الثنائية المحجوزة', 'Rencontres Bilatérales Programmées', 'Scheduled Bilateral Meetings') }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-black {{ $activeTab === 'MEETINGS' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                    {{ $scheduledMeetingsCount }}
                </span>
            </button>

            <button wire:click="$set('activeTab', 'MINISTERS')"
                    class="px-5 py-3 rounded-2xl font-black text-xs transition flex items-center gap-2.5 shadow-sm {{ $activeTab === 'MINISTERS' ? 'bg-[#06205C] text-white shadow-md ring-2 ring-blue-500/30' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 border border-slate-200/80 dark:border-slate-700' }}">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>{{ $t('حالة توافر وجاهزية الوزراء والمدراء', 'Disponibilité des Ministres & Officiels', 'Ministers Availability Status') }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-black {{ $activeTab === 'MINISTERS' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                    {{ $totalMinistersCount }}
                </span>
            </button>

            <button wire:click="$set('activeTab', 'ROOMS')"
                    class="px-5 py-3 rounded-2xl font-black text-xs transition flex items-center gap-2.5 shadow-sm {{ $activeTab === 'ROOMS' ? 'bg-[#06205C] text-white shadow-md ring-2 ring-blue-500/30' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 border border-slate-200/80 dark:border-slate-700' }}">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
                <span>{{ $t('دليل وتوقيتات قاعات الاجتماعات', 'Salons VIP & Planning', 'VIP Lounges & Schedule') }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-black {{ $activeTab === 'ROOMS' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                    {{ $activeRoomsCount }}
                </span>
            </button>
        </div>

        {{-- ── TAB 1: SCHEDULED MEETINGS & ROOM RESERVATIONS ── --}}
        @if($activeTab === 'MEETINGS')
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-xl overflow-hidden">
                
                {{-- Table/Card Header Bar --}}
                <div class="p-6 bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-2xl bg-amber-500/10 text-amber-500 border border-amber-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-[#06205C] dark:text-white">
                                {{ $t('جدول المحادثات والمواعيد الثنائية المحجوزة', 'Liste des Entretiens Bilatéraux', 'Scheduled Bilateral Sessions') }}
                            </h3>
                            <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5">
                                {{ $t('تتبع مواعيد قاعات VIP، أطراف المباحثات، والحالة الزمنية للجلسات', 'Suivi des créneaux VIP et des parties prenantes', 'Track VIP room slots, bilateral parties, and meeting status') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select wire:model.live="selectedStatus" class="w-full sm:w-48 px-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition shadow-xs">
                            <option value="ALL">{{ $t('جميع الحالات', 'Tous les statuts', 'All Statuses') }}</option>
                            <option value="SCHEDULED">{{ $t('مجدول ومثبت', 'Programmé', 'Scheduled') }}</option>
                            <option value="IN_PROGRESS">{{ $t('جاري الآن (In Session)', 'En cours', 'In Progress') }}</option>
                            <option value="COMPLETED">{{ $t('مكتمل', 'Terminé', 'Completed') }}</option>
                            <option value="CANCELLED">{{ $t('ملغى', 'Annulé', 'Cancelled') }}</option>
                        </select>
                    </div>
                </div>

                {{-- Meetings Cards List --}}
                <div class="divide-y divide-slate-100 dark:divide-slate-700/80">
                    @forelse($meetings as $mtg)
                        <div class="p-6 hover:bg-slate-50/60 dark:hover:bg-slate-700/30 transition flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            
                            {{-- Meeting details & Ministers --}}
                            <div class="space-y-4 flex-1">
                                
                                {{-- Status & Time badges --}}
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-3.5 py-1.5 rounded-full text-xs font-mono font-black bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800/60 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $mtg->start_time->format('Y-m-d') }}</span>
                                        <span class="text-blue-300 dark:text-blue-600">|</span>
                                        <span>{{ $mtg->start_time->format('H:i') }} — {{ $mtg->end_time->format('H:i') }}</span>
                                    </span>

                                    <span class="px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider border
                                        {{ $mtg->status === 'SCHEDULED' ? 'bg-amber-50 dark:bg-amber-950/60 text-amber-900 dark:text-amber-200 border-amber-300 dark:border-amber-800' : ($mtg->status === 'IN_PROGRESS' ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-900 dark:text-emerald-200 border-emerald-300 dark:border-emerald-800 animate-pulse' : ($mtg->status === 'COMPLETED' ? 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-600' : 'bg-rose-50 dark:bg-rose-950/60 text-rose-900 dark:text-rose-200 border-rose-300 dark:border-rose-800')) }}">
                                        {{ $mtg->status }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h4 class="text-lg font-black text-[#06205C] dark:text-white leading-tight">
                                    {{ $mtg->title }}
                                </h4>

                                {{-- Ministers Pair Grid --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                                    
                                    {{-- Host Minister --}}
                                    <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-50/80 to-slate-50 dark:from-blue-950/40 dark:to-slate-900/40 border border-blue-100 dark:border-blue-900/60 flex items-center gap-3.5 shadow-xs">
                                        <div class="w-11 h-11 rounded-2xl bg-[#06205C] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-md">
                                            {{ $mtg->hostMinister?->country?->code ?? 'DZA' }}
                                        </div>
                                        <div class="space-y-0.5">
                                            <span class="text-[10px] text-blue-600 dark:text-blue-400 font-black uppercase tracking-wider block">{{ $t('الطرف المستضيف', 'Partie Hôte', 'Host Official') }}</span>
                                            <span class="font-black text-sm text-slate-900 dark:text-slate-100 block">{{ $mtg->hostMinister?->full_name }}</span>
                                            <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block">{{ $mtg->hostMinister?->title_ar }}</span>
                                        </div>
                                    </div>

                                    {{-- Guest Minister --}}
                                    <div class="p-4 rounded-2xl bg-gradient-to-r from-amber-50/80 to-slate-50 dark:from-amber-950/40 dark:to-slate-900/40 border border-amber-200/80 dark:border-amber-900/60 flex items-center gap-3.5 shadow-xs">
                                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 flex items-center justify-center font-black text-xs shrink-0 shadow-md">
                                            {{ $mtg->guestMinister?->country?->code ?? 'VIP' }}
                                        </div>
                                        <div class="space-y-0.5">
                                            <span class="text-[10px] text-amber-700 dark:text-amber-400 font-black uppercase tracking-wider block">{{ $t('الضيف الرسمي', 'Invité Officiel', 'Guest Official') }}</span>
                                            <span class="font-black text-sm text-slate-900 dark:text-slate-100 block">{{ $mtg->guestMinister?->full_name }}</span>
                                            <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block">{{ $mtg->guestMinister?->title_ar }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Reserved Room details & Actions --}}
                            <div class="lg:w-80 shrink-0 bg-slate-50 dark:bg-slate-900/60 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700 space-y-4 shadow-xs">
                                <div>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-400 font-black uppercase tracking-wider block">{{ $t('القاعة المحجوزة', 'Salon VIP Réservé', 'Reserved Lounge') }}</span>
                                    <span class="font-black text-sm text-[#06205C] dark:text-white block mt-1 leading-snug">{{ $mtg->room?->getLocalized('name') }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block mt-0.5">{{ $mtg->room?->location_zone }}</span>
                                </div>

                                @if($mtg->status === 'SCHEDULED')
                                    <button wire:click="cancelMeeting({{ $mtg->id }})" class="w-full py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800 font-black text-xs transition shadow-xs">
                                        {{ $t('إلغاء حجز الموعد', 'Annuler Rendez-vous', 'Cancel Reservation') }}
                                    </button>
                                @endif
                            </div>

                        </div>
                    @empty
                        <div class="p-16 text-center text-slate-400 font-bold text-xs space-y-3">
                            <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-sm font-black text-slate-600 dark:text-slate-300">{{ $t('لا توجد لقاءات ثنائية مجدولة حالياً.', 'Aucune rencontre bilatérale programmée.', 'No bilateral meetings currently scheduled.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- ── TAB 2: MINISTERS & EXECUTIVE AVAILABILITY COMMAND ── --}}
        @if($activeTab === 'MINISTERS')
            <div class="space-y-6">
                <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="relative w-full sm:w-96">
                        <input type="text" wire:model.live.debounce.300ms="searchQuery"
                               placeholder="{{ $t('بحث باسم الوزير أو الوزارة...', 'Rechercher par nom ou ministère...', 'Search minister name or ministry...') }}"
                               class="w-full ps-10 pe-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition">
                        <svg class="w-4 h-4 text-slate-400 absolute start-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <div class="text-xs font-black text-slate-500 dark:text-slate-400">
                        {{ count($ministers) }} {{ $t('مسؤول وزاري ودبلوماسي مسجل', 'officiels enregistrés', 'registered officials') }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($ministers as $min)
                        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-lg p-6 space-y-5 flex flex-col justify-between hover:border-blue-500/40 transition">
                            
                            {{-- Top Header --}}
                            <div class="space-y-4">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 font-mono font-black text-xs border border-blue-200 dark:border-blue-800">
                                            {{ $min->country?->code ?? 'DZA' }}
                                        </span>
                                        <span class="px-2.5 py-1 rounded-full bg-gradient-to-r from-amber-400 via-amber-500 to-yellow-500 text-slate-950 font-black text-[10px] tracking-wider uppercase border border-amber-300 shadow-xs">
                                            VIP DIPLOMATIC
                                        </span>
                                    </div>

                                    {{-- Availability Badge --}}
                                    @php
                                        $st = $min->availability_status;
                                        $stBadge = match($st) {
                                            'AVAILABLE'  => ['bg-emerald-50 text-emerald-900 border-emerald-300 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800', $t('متاح للعمل واللقاءات', 'Disponible', 'Available')],
                                            'BUSY'       => ['bg-rose-50 text-rose-900 border-rose-300 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800', $t('في اجتماع / غير متاح', 'En Réunion', 'Busy')],
                                            'IN_SESSION' => ['bg-amber-50 text-amber-900 border-amber-300 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800', $t('في الجلسة العامة', 'En Session', 'In Session')],
                                            default      => ['bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600', $t('خارج ساعات العمل', 'Hors Service', 'Off Duty')],
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black border uppercase {{ $stBadge[0] }}">
                                        {{ $stBadge[1] }}
                                    </span>
                                </div>

                                <div>
                                    <h3 class="text-lg font-black text-[#06205C] dark:text-white leading-tight">
                                        {{ $min->full_name }}
                                    </h3>
                                    <p class="text-xs text-amber-600 dark:text-amber-400 font-bold mt-1">
                                        {{ $min->title_ar }}
                                    </p>
                                    <span class="text-xs text-slate-400 dark:text-slate-400 font-medium block mt-1 leading-snug">
                                        {{ $min->ministry_name }}
                                    </span>
                                </div>
                            </div>

                            {{-- Status Toggle Buttons & Booking Action --}}
                            <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                                <span class="text-[10px] text-slate-400 font-black uppercase tracking-wider block">{{ $t('تحديث حالة التوافر الحالية:', 'Changer statut disponible:', 'Update Availability:') }}</span>
                                
                                <div class="grid grid-cols-2 gap-2 text-[11px] font-black">
                                    <button wire:click="updateMinisterStatus({{ $min->id }}, 'AVAILABLE')" class="py-2 px-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-center transition shadow-xs">
                                        {{ $t('متاح', 'Disponible', 'Available') }}
                                    </button>

                                    <button wire:click="updateMinisterStatus({{ $min->id }}, 'BUSY')" class="py-2 px-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-800 border border-rose-200 text-center transition shadow-xs">
                                        {{ $t('في اجتماع', 'En Réunion', 'Busy') }}
                                    </button>

                                    <button wire:click="updateMinisterStatus({{ $min->id }}, 'IN_SESSION')" class="py-2 px-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-center transition shadow-xs">
                                        {{ $t('في الجلسة', 'En Session', 'In Session') }}
                                    </button>

                                    <button wire:click="updateMinisterStatus({{ $min->id }}, 'OFF_DUTY')" class="py-2 px-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200 text-center transition shadow-xs">
                                        {{ $t('غير متاح', 'Hors Service', 'Off Duty') }}
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    <button wire:click="openBookingModal({{ $min->id }})" class="py-3 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-md transition flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>{{ $t('حجز موعد', 'Réserver', 'Book Talk') }}</span>
                                    </button>

                                    <button wire:click="showMinisterCredentials({{ $min->id }})" class="py-3 rounded-2xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 dark:text-amber-300 border border-amber-300 dark:border-amber-700 font-black text-xs transition flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"/></svg>
                                        <span>{{ $t('بطاقة الدخول', 'Identifiants', 'Credentials') }}</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── TAB 3: DIPLOMATIC ROOMS & REAL-TIME SCHEDULE ── --}}
        @if($activeTab === 'ROOMS')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach($rooms as $rm)
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-lg p-6 space-y-5 flex flex-col justify-between hover:border-purple-500/40 transition">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-3.5 py-1.5 rounded-full text-xs font-black uppercase bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                    {{ $rm->location_zone }}
                                </span>
                                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    {{ $rm->capacity }} {{ $t('مقعد ثنائي VIP', 'Sièges VIP', 'VIP Seats') }}
                                </span>
                            </div>

                            <h3 class="text-lg font-black text-[#06205C] dark:text-white leading-snug">
                                {{ $rm->getLocalized('name') }}
                            </h3>

                            {{-- Today's Schedule for this room --}}
                            <div class="space-y-2.5 pt-2">
                                <span class="text-[10px] text-slate-400 font-black uppercase tracking-wider block">{{ $t('مواعيد الحجز لهذا اليوم:', 'Réservations du jour:', 'Today\'s Slot Schedule:') }}</span>
                                @forelse($rm->meetings as $rMtg)
                                    <div class="p-3 rounded-2xl bg-amber-50/80 dark:bg-amber-950/40 border border-amber-200/80 text-xs font-bold text-amber-900 dark:text-amber-200 flex items-center justify-between shadow-xs">
                                        <span class="font-mono text-xs font-black">{{ $rMtg->start_time->format('H:i') }} - {{ $rMtg->end_time->format('H:i') }}</span>
                                        <span class="truncate max-w-[150px] font-black">{{ $rMtg->title }}</span>
                                    </div>
                                @empty
                                    <span class="text-emerald-600 dark:text-emerald-400 text-xs font-bold block bg-emerald-50/60 dark:bg-emerald-950/40 p-3 rounded-2xl border border-emerald-200 dark:border-emerald-800">
                                        {{ $t('القاعة متاحة بالكامل للحجز اليوم', 'Salon disponible toute la journée', 'Lounge available all day') }}
                                    </span>
                                @endforelse
                            </div>
                        </div>

                        <button wire:click="openBookingModal(null, {{ $rm->id }})" class="w-full py-3 rounded-2xl bg-purple-700 hover:bg-purple-800 text-white font-black text-xs shadow-md transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $t('حجز هذه القاعة الآن', 'Réserver ce Salon VIP', 'Book This VIP Lounge') }}</span>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

    </div> {{-- END .printable-hide-on-print --}}

    {{-- ── BOOKING DIPLOMATIC MEETING MODAL ── --}}
    @if($showBookingModal)
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[90vh] overflow-y-auto my-auto animate-scale-up">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/80 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-[#06205C] text-white flex items-center justify-center font-black shrink-0 shadow-md">
                            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">
                                {{ $t('حجز لقاء ثنائي وقاعة اجتماعات دبلوماسية', 'Réservation d\'un Entretien Bilatéral', 'Book Bilateral Meeting & Diplomatic Lounge') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold mt-0.5">{{ $t('تحديد الأطراف، القاعة، والتوقيت الزمني الدقيق.', 'Spécifiez les officiels, le salon VIP et le créneau horaire.', 'Specify officials, lounge room, and exact time slot.') }}</p>
                        </div>
                    </div>
                    <button wire:click="$set('showBookingModal', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-black text-lg">✕</button>
                </div>

                @if($errorMessage)
                    <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-900 dark:text-rose-200 text-xs font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>{{ $errorMessage }}</span>
                    </div>
                @endif

                <div class="space-y-4">
                    
                    {{-- Meeting Title --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('عنوان المباحثات الثنائية *', 'Titre de la Rencontre *', 'Bilateral Session Title *') }}
                        </label>
                        <input type="text" wire:model="meetingTitle" placeholder="{{ $t('مثال: جلسة مباحثات الجزائر-مصر حول التكوين والمهن', 'Ex: Entretien Algérie-Égypte sur la formation', 'Ex: Algeria-Egypt Bilateral Session') }}"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition">
                        @error('meetingTitle') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Host & Guest Ministers --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">
                                {{ $t('الوزير المستضيف (الجزائر) *', 'Ministre Hôte *', 'Host Official *') }}
                            </label>
                            <select wire:model="hostMinisterId" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition">
                                <option value="">{{ $t('-- اختر الوزير المستضيف --', '-- Sélectionner --', '-- Select --') }}</option>
                                @foreach($ministers as $mOption)
                                    <option value="{{ $mOption->id }}">{{ $mOption->country?->code }} — {{ $mOption->full_name }} ({{ $mOption->title_ar }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">
                                {{ $t('الوزير الضيف (الوفد الإفريقي) *', 'Ministre Invité *', 'Guest Official *') }}
                            </label>
                            <select wire:model="guestMinisterId" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition">
                                <option value="">{{ $t('-- اختر الوزير الضيف --', '-- Sélectionner --', '-- Select --') }}</option>
                                @foreach($ministers as $mOption)
                                    <option value="{{ $mOption->id }}">{{ $mOption->country?->code }} — {{ $mOption->full_name }} ({{ $mOption->title_ar }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Diplomatic Room --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('قاعة الاجتماعات الدبلوماسية *', 'Salon VIP d\'Accueil *', 'Diplomatic Lounge Room *') }}
                        </label>
                        <select wire:model="roomId" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition">
                            <option value="">{{ $t('-- اختر قاعة الاجتماعات --', '-- Sélectionner --', '-- Select --') }}</option>
                            @foreach($rooms as $rOption)
                                <option value="{{ $rOption->id }}">{{ $rOption->getLocalized('name') }} ({{ $rOption->capacity }} seat)</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date & Time Slots --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('التاريخ *', 'Date *', 'Date *') }}</label>
                            <input type="date" wire:model="meetingDate" class="w-full px-3.5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('من الساعة *', 'Heure début *', 'From Time *') }}</label>
                            <input type="time" wire:model="startTime" class="w-full px-3.5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('إلى الساعة *', 'Heure fin *', 'To Time *') }}</label>
                            <input type="time" wire:model="endTime" class="w-full px-3.5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>
                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showBookingModal', false)" type="button" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs transition">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="createBilateralMeeting" type="button" class="px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-lg transition">
                        {{ $t('تأكيد وحجز القاعة', 'Confirmer la réservation', 'Confirm Booking') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ── ADD NEW MINISTER MODAL ── --}}
    @if($showAddMinisterModal)
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[90vh] overflow-y-auto my-auto animate-scale-up">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/80 pb-4">
                    <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">
                        {{ $t('إضافة وزير أو مسؤول حكومي رفيع المستوى', 'Ajouter un Ministre ou Officiel', 'Add Minister or High Government Official') }}
                    </h3>
                    <button wire:click="$set('showAddMinisterModal', false)" class="p-2 text-slate-400 hover:text-slate-600 font-black text-lg">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الدولة *', 'Pays *', 'Country *') }}</label>
                        <select wire:model="newMinisterCountryId" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            <option value="">{{ $t('-- اختر الدولة --', '-- Sélectionner --', '-- Select --') }}</option>
                            @foreach($countries as $cOpt)
                                <option value="{{ $cOpt->id }}">{{ $cOpt->code }} — {{ $cOpt->getLocalized('name') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الاسم الكامل *', 'Nom complet *', 'Full Name *') }}</label>
                        <input type="text" wire:model="newMinisterName" placeholder="{{ $t('معالي الوزير...', 'Son Excellence...', 'His Excellency...') }}" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('المنصب الوزاري بالعربية *', 'Titre Ministériel (Arabe) *', 'Ministerial Title (Arabic) *') }}</label>
                        <input type="text" wire:model="newMinisterTitleAr" placeholder="{{ $t('وزير التكوين والتعليم المهنيين...', 'Ministre...', 'Minister of...') }}" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الوزارة / الهيئة الرسمية *', 'Ministère / Organisme *', 'Ministry / Entity *') }}</label>
                        <input type="text" wire:model="newMinisterMinistry" placeholder="{{ $t('وزارة التكوين والتعليم المهنيين', 'Ministère de la Formation', 'Ministry of Vocational Training') }}" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showAddMinisterModal', false)" type="button" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs transition">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="saveMinister" type="button" class="px-6 py-3 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-lg transition">
                        {{ $t('حفظ المسؤول الوزاري', 'Enregistrer Officiel', 'Save Ministerial Official') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ── SHOW MINISTER CREDENTIALS PASS MODAL ── --}}
    @if($showCredentialModal && !empty($credentialData))
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200 dark:border-slate-700 my-auto text-center relative overflow-hidden">
                
                {{-- Decorative Header Banner --}}
                <div class="absolute top-0 inset-x-0 h-3 bg-gradient-to-r from-amber-400 via-amber-500 to-yellow-500"></div>

                <div class="flex justify-between items-center pb-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-[10px] font-mono font-black text-amber-600 dark:text-amber-400 uppercase tracking-widest">
                        VIP DIPLOMATIC PASS
                    </span>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 font-black text-lg">✕</button>
                </div>

                {{-- VIP Pass Badge Layout --}}
                <div class="p-6 rounded-3xl bg-gradient-to-b from-[#020A24] via-[#06205C] to-[#0A3580] text-white border border-amber-500/30 space-y-4 shadow-xl text-start relative overflow-hidden">
                    <div class="flex items-center justify-between gap-2">
                        <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 font-mono text-[10px] font-black uppercase border border-amber-500/40">
                            {{ $credentialData['country_code'] ?? 'DZA' }} OFFICIAL PASS
                        </span>
                        <img src="/logo.svg" alt="WorldSkills Algeria" class="h-6 w-auto">
                    </div>

                    <div class="pt-2">
                        <h4 class="text-lg font-black text-white leading-tight">
                            {{ $credentialData['name'] ?? '' }}
                        </h4>
                        <p class="text-xs text-amber-300 font-bold mt-1">
                            {{ $credentialData['title'] ?? '' }}
                        </p>
                        <p class="text-[11px] text-blue-200/80 font-medium block mt-0.5">
                            {{ $credentialData['ministry'] ?? '' }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-white/10 space-y-2 font-mono text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-blue-300/70 text-[10px] uppercase font-bold">{{ $t('اسم المستخدم (Email)', 'Identifiant', 'Username') }}:</span>
                            <span class="font-bold text-white text-[11px]">{{ $credentialData['email'] ?? '' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-blue-300/70 text-[10px] uppercase font-bold">{{ $t('كلمة المرور الرسمية', 'Mot de Passe', 'Initial Password') }}:</span>
                            <span class="font-bold text-amber-400 text-[11px]">Ministry2026!</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-3 pt-2">
                    <button onclick="window.print()" class="px-6 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>{{ $t('طباعة البطاقة الرسمية', 'Imprimer le Pass', 'Print Official Pass') }}</span>
                    </button>

                    <button wire:click="closeModal" class="px-5 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs transition">
                        {{ $t('إغلاق', 'Fermer', 'Close') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
