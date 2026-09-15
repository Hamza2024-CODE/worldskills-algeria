@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };

$totalFlights = count($uploaded_tickets);
$totalPassengers = $uploaded_tickets->sum('passenger_count');
$confirmedShuttles = $uploaded_tickets->where('status', 'APPROVED')->count();
@endphp

<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8 px-4 sm:px-6 lg:px-8 text-slate-900 dark:text-white font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-6xl mx-auto space-y-8">
        
        <!-- Header Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0A3580] p-8 border-2 border-amber-400/40 shadow-xl text-white">
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-sky-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 border border-amber-400/40 text-amber-300 text-xs font-black">
                        <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>WORLDSKILLS AFRICA 2026 LOGISTICS SUITE</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        {{ $t('إدارة وصول الوفود الإفريقية وتذاكر الطيران الرسمية', 'Gestion des Arrivées & Billets d\'Avion Officiels', 'African Delegations Arrival & Official Flight Tickets Portal') }}
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm max-w-2xl font-medium">
                        {{ $t('منصة تسجيل مواعيد الوصول وتأكيد تذاكر الطيران الرسمية عبر المطارات الوطنية.', 'Portail officiel d\'enregistrement des dates d\'arrivée et des billets d\'avion.', 'Official arrival dates & flight ticket credentials portal for African delegations.') }}
                    </p>
                </div>
                
                <div class="shrink-0 flex items-center gap-3">
                    <img src="/LOGO01.png" alt="State Seal" class="h-16 w-auto object-contain filter drop-shadow-md">
                    <img src="/logo.svg" alt="WorldSkills Logo" class="h-12 w-auto filter brightness-0 invert">
                </div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200 text-xs font-bold flex items-center gap-3 shadow-md">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <!-- LIVE LOGISTICS COUNTER CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                        {{ $t('إجمالي الرحلات الجوية المسجلة', 'Vols Enregistrés', 'Total Flights Registered') }}
                    </span>
                    <span class="text-2xl font-black text-[#06205C] dark:text-white block">{{ $totalFlights }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-sky-400 flex items-center justify-center border border-blue-200 dark:border-blue-900 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </div>
            </div>

            <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                        {{ $t('إجمالي المسافرين وأعضاء الوفد', 'Passagers Enregistrés', 'Total Passengers Registered') }}
                    </span>
                    <span class="text-2xl font-black text-amber-600 dark:text-amber-400 block">{{ $totalPassengers }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-300 flex items-center justify-center border border-amber-200 dark:border-amber-900 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>

            <div class="p-5 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                        {{ $t('الاستقبال والحافلات المعتمدة', 'Accueil & Bus Confirmés', 'Confirmed Reception Shuttles') }}
                    </span>
                    <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400 block">{{ $confirmedShuttles }}</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-300 flex items-center justify-center border border-emerald-200 dark:border-emerald-900 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Grid Layout: Flight Registration Form + Arrival Records Table -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Form: Flight Arrival Entry -->
            <div class="lg:col-span-5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-6 shadow-md space-y-6">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h2 class="text-lg font-extrabold text-[#06205C] dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>{{ $t('تسجيل موعد الوصول وتذكرة الطيران', 'Enregistrer une Arrivée', 'Register Arrival & Flight Ticket') }}</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        {{ $t('أدخل معلومات الرحلة الجوية وارفق تذكرة الطائرة (صورة أو ملف PDF)', 'Saisissez les informations du vol et joignez le billet (PDF ou image)', 'Enter flight details and attach flight ticket (PDF or image)') }}
                    </p>
                </div>

                <form wire:submit.prevent="submitArrivalInfo" class="space-y-4">
                    
                    <!-- Date & Time -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                {{ $t('تاريخ الوصول الرسمي', 'Date d\'arrivée officielle', 'Official Arrival Date') }}
                            </label>
                            <input type="date" wire:model="arrival_date" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                            @error('arrival_date') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                {{ $t('توقيت الوصول', 'Heure d\'arrivée (Locale)', 'Arrival Time (Local)') }}
                            </label>
                            <input type="time" wire:model="arrival_time" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                            @error('arrival_time') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Airline & Flight Number -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                {{ $t('شركة الطيران', 'Compagnie Aérienne', 'Airline Name') }}
                            </label>
                            <input type="text" wire:model="airline_name" placeholder="Air Algérie, EgyptAir..." class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                            @error('airline_name') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                {{ $t('رقم الرحلة الجوية', 'Numéro de Vol', 'Flight Number') }}
                            </label>
                            <input type="text" wire:model="flight_number" placeholder="AH-1004 / MS-845" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                            @error('flight_number') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Passenger Count & Airport -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('مطار الوصول المحدد', 'Aéroport d\'Arrivée', 'Arrival Airport') }}
                        </label>
                        <select wire:model="arrival_airport" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="مطار الهواري بومدين الدولي - الجزائر العاصمة">
                                {{ $t('مطار الهواري بومدين الدولي (ALG) - الجزائر العاصمة', 'Aéroport Houari Boumediene (ALG) - Alger', 'Houari Boumediene International Airport (ALG) - Algiers') }}
                            </option>
                            <option value="مطار وهران الدولي - أحمد بن بلة">
                                {{ $t('مطار وهران الدولي - أحمد بن بلة (ORN)', 'Aéroport d\'Oran Ahmed Ben Bella (ORN)', 'Oran Ahmed Ben Bella International Airport (ORN)') }}
                            </option>
                            <option value="مطار قسنطينة الدولي - محمد بوضياف">
                                {{ $t('مطار قسنطينة الدولي - محمد بوضياف (CZL)', 'Aéroport de Constantine Mohamed Boudiaf (CZL)', 'Constantine Mohamed Boudiaf Airport (CZL)') }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('عدد أعضاء الوفد القادمين في هذه الرحلة', 'Nombre de Passagers', 'Number of Passengers in Flight') }}
                        </label>
                        <input type="number" min="1" max="150" wire:model="passenger_count" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <!-- Flight Ticket File Upload (PDF / Image) -->
                    <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 hover:border-blue-500 rounded-2xl p-4 text-center bg-slate-50/50 dark:bg-slate-900/50 transition">
                        <label class="cursor-pointer block space-y-2">
                            <svg class="w-9 h-9 text-blue-600 dark:text-sky-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">
                                {{ $t('ارفق تذكرة الطائرة الرسمية (PDF أو صورة)', 'Joindre le billet d\'avion (PDF ou Image)', 'Attach Official Flight Ticket (PDF or Image)') }}
                            </span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400 block">PDF, PNG, JPG (Max 10MB)</span>
                            <input type="file" wire:model="flight_ticket_file" class="hidden" accept=".pdf,.png,.jpg,.jpeg">
                        </label>

                        @if ($flight_ticket_file ?? null)
                            <div class="mt-3 p-2 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 rounded-xl text-xs text-blue-800 dark:text-blue-200 flex items-center justify-between font-bold">
                                <span class="flex items-center gap-1.5 truncate">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span class="truncate">{{ $flight_ticket_file->getClientOriginalName() }}</span>
                                </span>
                                <span class="text-[10px] bg-blue-600 px-2 py-0.5 rounded text-white font-bold shrink-0">
                                    {{ $t('جاهز للرفع', 'Prêt', 'Ready') }}
                                </span>
                            </div>
                        @endif
                        @error('flight_ticket_file') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('ملاحظات لوجستية إضافية (أمتعة خاصة، استقبال، إلخ)', 'Notes logistiques particulières', 'Additional Logistics Notes') }}
                        </label>
                        <textarea wire:model="notes" rows="2" placeholder="{{ $t('ملاحظات حول استقبال الوفد والمعدات...', 'Remarques sur l\'accueil...', 'Notes on reception...') }}" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-md transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $t('تأكيد وتسديد بيانات الوصول وتذكرة الطيران', 'Confirmer & Enregistrer l\'Arrivée', 'Confirm & Submit Arrival Details') }}</span>
                    </button>
                </form>
            </div>

            <!-- Right Records Table: Registered Arrivals & Ticket Documents -->
            <div class="lg:col-span-7 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-6 shadow-md space-y-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                        <div>
                            <h2 class="text-lg font-extrabold text-[#06205C] dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $t('جدول وصول الوفد وتذاكر الطيران المعتمدة', 'Planning des Arrivées & Billets Confirmés', 'Confirmed Arrival Schedule & Tickets') }}</span>
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                {{ $t('قائمة الرحلات الجوية والبطاقات المسجلة رسمياً للوفد.', 'Liste des vols officiellement enregistrés.', 'Officially recorded delegation flights list.') }}
                            </p>
                        </div>
                        
                        <span class="px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-900 text-xs font-black">
                            {{ count($uploaded_tickets) }} {{ $t('رحلة مسجلة', 'vol(s)', 'flight(s)') }}
                        </span>
                    </div>

                    <!-- Records Cards List -->
                    <div class="space-y-4 mt-6">
                        @forelse ($uploaded_tickets as $ticket)
                            <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 transition">
                                
                                <div class="flex items-start justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-black text-[#06205C] dark:text-amber-300">{{ $ticket['airline_name'] }}</span>
                                            <span class="px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 font-mono text-xs font-bold text-blue-700 dark:text-sky-300">{{ $ticket['flight_number'] }}</span>
                                        </div>
                                        <p class="text-xs text-slate-600 dark:text-slate-300 font-bold flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span>{{ $ticket['arrival_airport'] }}</span>
                                        </p>
                                    </div>

                                    <span class="px-3 py-1 rounded-full text-xs font-black {{ $ticket['status'] === 'APPROVED' ? 'bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-200 border border-emerald-200' : 'bg-amber-50 dark:bg-amber-950 text-amber-800 dark:text-amber-200 border border-amber-200' }}">
                                        {{ $ticket['status'] === 'APPROVED' ? $t('تم اعتماد الاستقبال', 'Accueil Confirmé', 'Arrival Confirmed') : $t('جاري مراجعة اللوجستيك', 'En Cours', 'Processing') }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-xs text-slate-700 dark:text-slate-300">
                                    <div>
                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 block">{{ $t('تاريخ وتوقيت الوصول:', 'Date & Heure:', 'Arrival Date & Time:') }}</span>
                                        <span class="font-bold font-mono text-slate-900 dark:text-white">{{ $ticket['arrival_date'] }} — {{ $ticket['arrival_time'] }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 block">{{ $t('عدد أعضاء الوفد:', 'Passagers:', 'Passenger Count:') }}</span>
                                        <span class="font-bold text-[#06205C] dark:text-amber-300">{{ $ticket['passenger_count'] }} {{ $t('شخص', 'personne(s)', 'person(s)') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 block">{{ $t('حافلة الاستقبال المخصصة:', 'Bus d\'accueil:', 'Shuttle Assigned:') }}</span>
                                        <span class="font-bold text-blue-700 dark:text-sky-300">{{ $ticket['shuttle_assigned'] }}</span>
                                    </div>
                                </div>

                                @if ($ticket['notes'])
                                    <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-300">
                                        <span class="font-bold text-amber-700 dark:text-amber-400">{{ $t('ملاحظات:', 'Notes:', 'Notes:') }}</span> {{ $ticket['notes'] }}
                                    </div>
                                @endif

                                <!-- Ticket Document Attachment Action -->
                                <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        <span class="font-mono truncate max-w-[200px]">{{ $ticket['ticket_filename'] }}</span>
                                    </div>

                                    @if ($ticket['ticket_path'])
                                        <a href="{{ $ticket['ticket_path'] }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 dark:bg-blue-950 dark:hover:bg-blue-900 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 text-xs font-bold transition flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>{{ $t('معاينة تذكرة الطيران', 'Voir le billet', 'View Ticket') }}</span>
                                        </a>
                                    @else
                                        <span class="text-[11px] text-slate-400 italic">{{ $t('تذكرة افتراضية معتمدة', 'Billet virtuel validé', 'Virtual ticket confirmed') }}</span>
                                    @endif
                                </div>

                            </div>
                        @empty
                            <div class="py-12 text-center text-slate-400 text-xs font-bold space-y-2">
                                <svg class="w-10 h-10 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                <p>{{ $t('لم يتم تسجيل أي تذاكر طيران أو رحلات وصول حتى الآن.', 'Aucun vol ou billet enregistré pour le moment.', 'No flight tickets or arrival dates recorded yet.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-6 p-4 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900 text-xs text-slate-700 dark:text-slate-300 flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $t('يتم مراجعة وتأكيد تذاكر الطيران تلقائياً من قبل الخلية اللوجستية بمطار الهواري بومدين الدولي.', 'Validation automatique des billets par la cellule logistique de l\'aéroport.', 'Flight tickets automatically validated by airport logistics cell.') }}</span>
                    </span>
                    <span class="font-bold text-blue-800 dark:text-amber-300 shrink-0">LOGISTICS 2026</span>
                </div>
            </div>

        </div>

    </div>
</div>
