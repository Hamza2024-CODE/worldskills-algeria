@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-slate-700 pb-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-[#06205C] text-white flex items-center justify-center font-bold shadow-md">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        {{ $t('حجز قاعات المباحثات واللقاءات الوزارية', 'Réservation des Salons VIP & Entrevues Bilatérales', 'VIP Lounge & Bilateral Meeting Booking') }}
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">
                        {{ $t('دليل وتوقيتات قاعات الاجتماعات البروتوكولية وحجز جلسات المحادثات الثنائية.', 'Planning des salons diplomatiques et réservation de créneaux d\'entretiens.', 'Diplomatic lounges schedule and bilateral talk bookings.') }}
                    </p>
                </div>
            </div>
        </div>

        <button wire:click="openBookingModal" class="px-5 py-2.5 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs transition shadow-md flex items-center gap-2 self-start sm:self-auto border border-blue-900">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $t('حجز موعد لقاء ثنائي جديد', 'Nouveau Créneau VIP', 'Book New Bilateral Talk') }}</span>
        </button>
    </div>

    @if($flashMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ $flashMessage }}</span>
        </div>
    @endif

    {{-- VIP ROOMS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($rooms as $rm)
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-md space-y-4 flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950 text-blue-800 dark:text-blue-200 font-mono font-black text-[10px] uppercase border border-blue-200 dark:border-blue-900">
                            CAPACITY: {{ $rm->capacity }} VIPs
                        </span>
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    </div>

                    <h3 class="text-base font-black text-[#06205C] dark:text-white">
                        {{ $rm->getLocalized('name') }}
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                        {{ $rm->getLocalized('location') }}
                    </p>
                </div>

                <button wire:click="openBookingModal({{ $rm->id }})" class="w-full py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-black text-xs transition flex items-center justify-center gap-2 border border-slate-200 dark:border-slate-600">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $t('حجز هذه القاعة', 'Réserver ce Salon', 'Book This Lounge') }}</span>
                </button>
            </div>
        @endforeach
    </div>

    {{-- MY SCHEDULED MEETINGS TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-md overflow-hidden space-y-0">
        <div class="p-5 bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h3 class="text-sm font-black text-[#06205C] dark:text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $t('جدول اللقاءات والمباحثات المحجوزة', 'Liste des Entretiens Programmés', 'Scheduled Meetings Roster') }}</span>
            </h3>
        </div>

        <div class="divide-y divide-slate-100 dark:divide-slate-700">
            @forelse($myMeetings as $mtg)
                <div class="p-5 hover:bg-slate-50/70 dark:hover:bg-slate-700/40 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-black bg-blue-50 text-blue-800 dark:bg-blue-950 dark:text-blue-200 border border-blue-200 dark:border-blue-900">
                                {{ $mtg->start_time->format('Y-m-d H:i') }} — {{ $mtg->end_time->format('H:i') }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-50 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200 border border-emerald-200">
                                {{ $mtg->status }}
                            </span>
                        </div>

                        <h4 class="text-sm font-black text-slate-900 dark:text-white">
                            {{ $mtg->title }}
                        </h4>

                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                            <span class="font-bold text-[#06205C] dark:text-blue-400">{{ $mtg->hostMinister?->full_name }}</span>
                            ↔
                            <span class="font-bold text-amber-700 dark:text-amber-400">{{ $mtg->guestMinister?->full_name }}</span>
                            ({{ $mtg->room?->getLocalized('name') }})
                        </p>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-xs font-bold text-slate-400">
                    {{ $t('لا يوجد محادثات محجوزة حالياً', 'Aucun entretien programmé', 'No scheduled meetings found') }}
                </div>
            @endforelse
        </div>
    </div>

    {{-- BOOKING MODAL --}}
    @if($showBookingModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 space-y-5 border border-slate-200 dark:border-slate-700 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-[#06205C] dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ $t('حجز موعد مباحثات ثنائية في القاعة', 'Réservation de Salon VIP', 'Book VIP Lounges') }}</span>
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                @if($errorMessage)
                    <div class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold">
                        {{ $errorMessage }}
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('عنوان المباحثات الثنائية:', 'Titre de l\'entretien:', 'Session Title:') }}</label>
                        <input type="text" wire:model="meetingTitle" placeholder="{{ $t('مثال: جلسة مباحثات الشراكة والتأطير المهني', 'Ex: Entretien bilatéral...', 'Ex: Bilateral talk...') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الوزير / المسؤول المستضيف (Host):', 'Ministre Hôte:', 'Host Minister:') }}</label>
                        <select wire:model="hostMinisterId" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                            @foreach($ministers as $m)
                                <option value="{{ $m->id }}">{{ $m->full_name }} — {{ $m->title_ar }} ({{ $m->country?->code ?? 'DZA' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الوزير / الضيف الإفريقي (Guest):', 'Ministre Invité:', 'Guest Minister:') }}</label>
                        <select wire:model="guestMinisterId" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                            <option value="">-- {{ $t('اختر الوزير والضيف المرافق', 'Choisir Ministre Invité', 'Select Guest Minister') }} --</option>
                            @foreach($ministers as $m)
                                <option value="{{ $m->id }}">{{ $m->full_name }} — {{ $m->title_ar }} ({{ $m->country?->code ?? 'DZA' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('قاعة الاجتماعات الرسمية:', 'Salon VIP:', 'Meeting Room:') }}</label>
                        <select wire:model="roomId" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}">{{ $r->getLocalized('name') }} (Cap: {{ $r->capacity }} VIPs)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <div>
                            <label class="block text-[11px] font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('التاريخ', 'Date', 'Date') }}</label>
                            <input type="date" wire:model="meetingDate" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('البداية', 'Début', 'Start') }}</label>
                            <input type="time" wire:model="startTime" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('النهاية', 'Fin', 'End') }}</label>
                            <input type="time" wire:model="endTime" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="closeModal" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700">{{ $t('إلغاء', 'Annuler', 'Cancel') }}</button>
                    <button wire:click="saveBooking" class="px-5 py-2 rounded-xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-md">{{ $t('تأكيد وحجز القاعة', 'Confirmer la Réservation', 'Confirm Booking') }}</button>
                </div>
            </div>
        </div>
    @endif

</div>
