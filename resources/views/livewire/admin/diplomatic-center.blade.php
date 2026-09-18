<div class="space-y-6 pb-16">
    <!-- TOP HEADER BAR -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-slate-800/90 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs backdrop-blur-md">
        <div class="flex items-center gap-3.5">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-white flex items-center justify-center font-black shadow-lg shadow-amber-500/20 border border-amber-400/40">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        المركز الدبلوماسي واللقاءات الوزارية
                    </h1>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 border border-amber-300/60 dark:border-amber-800/60">
                        VIP Protocol
                    </span>
                </div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5">
                    إدارة أجندة الوزراء، الوفود الشرفية، وتنسيق حجز قاعات اللقاءات الثنائية المغلقة
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button wire:click="exportMeetingsExcel" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs transition flex items-center gap-2 border border-slate-200/60 dark:border-slate-600/60 shadow-xs">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>تصدير الأجندة CSV</span>
            </button>
            <button wire:click="$set('showAddMinisterModal', true)" class="px-4 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 active:scale-98 text-white font-black text-xs transition flex items-center gap-2 shadow-lg shadow-blue-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span>إضافة وزير / مسؤول</span>
            </button>
            <button wire:click="openBookingModal()" class="px-5 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 active:scale-98 text-white font-black text-xs transition flex items-center gap-2 shadow-lg shadow-amber-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>حجز لقاء ثنائي جديدة</span>
            </button>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if(!empty($flashMessage))
        <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 p-4 rounded-2xl flex items-center justify-between text-xs font-bold text-emerald-900 dark:text-emerald-200 shadow-xs">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $flashMessage }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="text-emerald-700 dark:text-emerald-400 hover:opacity-75">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    <!-- EXECUTIVE DIPLOMATIC KPI CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- KPI 1: Total Ministers -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between group hover:border-blue-500/50 transition">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">الوزراء والمسؤولون</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1 font-mono">{{ number_format($totalMinistersCount) }}</p>
                <p class="text-[10px] font-bold text-blue-600 dark:text-blue-400 mt-1">وفود رسمية معتمدة</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black shrink-0 border border-blue-500/20 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <!-- KPI 2: Available Ministers -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between group hover:border-emerald-500/50 transition">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">المتاحون للقاءات</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 font-mono">{{ number_format($availableMinistersCount) }}</p>
                <p class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 mt-1 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>جاهزون للحجز الفوري</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black shrink-0 border border-emerald-500/20 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- KPI 3: Scheduled Meetings -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between group hover:border-amber-500/50 transition">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">لقاءات ثنائية مجدولة</p>
                <p class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1 font-mono">{{ number_format($scheduledMeetingsCount) }}</p>
                <p class="text-[10px] font-bold text-amber-600 dark:text-amber-400 mt-1">جدول الأجندة الحكومية</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black shrink-0 border border-amber-500/20 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <!-- KPI 4: VIP Lounges -->
        <div class="bg-white dark:bg-slate-800/90 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between group hover:border-purple-500/50 transition">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">قاعات VIP الجاهزة</p>
                <p class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1 font-mono">{{ number_format($activeRoomsCount) }}</p>
                <p class="text-[10px] font-bold text-purple-600 dark:text-purple-400 mt-1">مستويات أمان وبروتوكول عالمية</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-black shrink-0 border border-purple-500/20 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
            </div>
        </div>
    </div>

    <!-- SEGMENTED NAVIGATION TABS -->
    <div class="flex items-center gap-2 p-1.5 rounded-2xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60 max-w-xl">
        <button wire:click="$set('activeTab', 'MEETINGS')" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-black transition flex items-center justify-center gap-2 {{ ($activeTab ?? 'MEETINGS') === 'MEETINGS' ? 'bg-white dark:bg-slate-700 text-amber-600 dark:text-amber-400 shadow-sm border border-slate-200/60 dark:border-slate-600/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><span>اللقاءات المجدولة</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-black {{ ($activeTab ?? 'MEETINGS') === 'MEETINGS' ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                {{ count($meetings) }}
            </span>
        </button>

        <button wire:click="$set('activeTab', 'MINISTERS')" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-black transition flex items-center justify-center gap-2 {{ ($activeTab ?? 'MEETINGS') === 'MINISTERS' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-sm border border-slate-200/60 dark:border-slate-600/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg><span>دليل الوزراء والشرفيين</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-black {{ ($activeTab ?? 'MEETINGS') === 'MINISTERS' ? 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                {{ count($ministers) }}
            </span>
        </button>

        <button wire:click="$set('activeTab', 'ROOMS')" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-black transition flex items-center justify-center gap-2 {{ ($activeTab ?? 'MEETINGS') === 'ROOMS' ? 'bg-white dark:bg-slate-700 text-purple-600 dark:text-purple-400 shadow-sm border border-slate-200/60 dark:border-slate-600/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg><span>قاعات VIP</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-black {{ ($activeTab ?? 'MEETINGS') === 'ROOMS' ? 'bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                {{ count($rooms) }}
            </span>
        </button>
    </div>

    <!-- TAB 1: SCHEDULED MEETINGS -->
    @if(($activeTab ?? 'MEETINGS') === 'MEETINGS')
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs overflow-hidden">
            <!-- Search & Filters -->
            <div class="p-5 border-b border-slate-100 dark:border-slate-700/60 flex flex-col md:flex-row gap-3 items-stretch md:items-center justify-between">
                <div class="relative w-full max-w-md">
                    <input type="text" wire:model.live.debounce.300ms="searchQuery" placeholder="بحث بعنوان اللقاء، اسم الوزير الضيف..." class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <div class="absolute left-3 top-3 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <select wire:model.live="selectedStatus" class="px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="ALL">جميع حالات اللقاءات</option>
                        <option value="SCHEDULED">مجدولة ومثبتة</option>
                        <option value="COMPLETED">مكتملة وناجحة</option>
                        <option value="CANCELLED">ملغاة</option>
                    </select>
                </div>
            </div>

            <!-- Meetings Cards / List -->
            <div class="p-6">
                @forelse($meetings as $meeting)
                    <div class="mb-4 bg-slate-50 dark:bg-slate-900/60 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 hover:border-amber-500/50 transition">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <!-- Meeting Details -->
                            <div class="space-y-2 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="px-3 py-1 rounded-xl text-[10px] font-black font-mono border {{ $meeting->status === 'SCHEDULED' ? 'bg-amber-100 text-amber-900 border-amber-300 dark:bg-amber-950 dark:text-amber-300 dark:border-amber-800' : ($meeting->status === 'COMPLETED' ? 'bg-emerald-100 text-emerald-900 border-emerald-300 dark:bg-emerald-950 dark:text-emerald-300 dark:border-emerald-800' : 'bg-slate-200 text-slate-700 border-slate-300 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600') }}">
                                        {{ $meeting->status === 'SCHEDULED' ? 'مجدول' : ($meeting->status === 'COMPLETED' ? 'مكتمل' : 'ملغى') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-xl bg-purple-50 text-purple-700 dark:bg-purple-950 dark:text-purple-300 border border-purple-200 dark:border-purple-800 text-[10px] font-bold">
                                        <svg class='w-3 h-3 text-purple-600 dark:text-purple-400 inline-block align-middle me-1' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6'/></svg><span>{{ $meeting->room?->name_ar ?? 'قاعة VIP' }}</span>
                                    </span>
                                    <span class="text-xs font-mono font-bold text-slate-500 dark:text-slate-400">
                                        <svg class="w-3 h-3 text-slate-400 inline-block align-middle me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ $meeting->start_time?->format('Y-m-d') }} | ⏰ {{ $meeting->start_time?->format('H:i') }} - {{ $meeting->end_time?->format('H:i') }}
                                    </span>
                                </div>

                                <h3 class="text-base font-black text-slate-900 dark:text-white">
                                    {{ $meeting->title }}
                                </h3>

                                @if($meeting->purpose)
                                    <p class="text-xs text-slate-600 dark:text-slate-400">
                                        <strong class="text-slate-900 dark:text-slate-200">موضوع اللقاء:</strong> {{ $meeting->purpose }}
                                    </p>
                                @endif
                            </div>

                            <!-- Ministers Parties -->
                            <div class="flex items-center gap-3 bg-white dark:bg-slate-800 p-3 px-4 rounded-2xl border border-slate-200/80 dark:border-slate-700/60 shrink-0">
                                <!-- Host (Algeria) -->
                                <div class="text-right">
                                    <div class="text-[11px] font-black text-slate-900 dark:text-white">{{ $meeting->hostMinister?->full_name ?? 'الطرف المضيف' }}</div>
                                    <div class="text-[10px] font-bold text-amber-600 dark:text-amber-400"> {{ $meeting->hostMinister?->title_ar }}</div>
                                </div>

                                <div class="w-7 h-7 rounded-full bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg></div>

                                <!-- Guest -->
                                <div class="text-left">
                                    <div class="text-[11px] font-black text-slate-900 dark:text-white">{{ $meeting->guestMinister?->full_name ?? 'الطرف الضيف' }}</div>
                                    <div class="text-[10px] font-bold text-blue-600 dark:text-blue-400"> {{ $meeting->guestMinister?->country?->name_ar }}</div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 shrink-0 justify-end">
                                @if($meeting->status === 'SCHEDULED')
                                    <button wire:click="markMeetingCompleted({{ $meeting->id }})" class="px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-xs">
                                        تأكيد الاكتمال
                                    </button>
                                    <button wire:click="cancelMeeting({{ $meeting->id }})" class="px-3 py-2 rounded-xl bg-rose-100 hover:bg-rose-200 dark:bg-rose-950 dark:hover:bg-rose-900 text-rose-700 dark:text-rose-300 font-bold text-xs transition">
                                        إلغاء الموعد
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-slate-400 dark:text-slate-500 font-bold">
                        <div class="max-w-xs mx-auto space-y-2">
                            <div class="w-10 h-10 rounded-2xl bg-slate-100 dark:bg-slate-700 text-slate-400 flex items-center justify-center mx-auto mb-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                            <p class="text-sm">لا توجد لقاءات دبلوماسية مجدولة حالياً مطابقة للبحث.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- TAB 2: MINISTERS DIRECTORY -->
    @if(($activeTab ?? 'MEETINGS') === 'MINISTERS')
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs overflow-hidden">
            <!-- Search Bar & Country Filter -->
            <div class="p-5 border-b border-slate-100 dark:border-slate-700/60 flex flex-col md:flex-row gap-3 justify-between">
                <div class="relative w-full max-w-md">
                    <input type="text" wire:model.live.debounce.300ms="searchQuery" placeholder="بحث باسم الوزير، الصفة الرسمية، الوزارة..." class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="absolute left-3 top-3 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <select wire:model.live="selectedCountryFilter" class="px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">جميع الدول والوفود</option>
                        @foreach($countries as $cnt)
                            <option value="{{ $cnt->id }}"> {{ $cnt->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Grid Cards of Ministers -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($ministers as $minister)
                    <div class="bg-slate-50 dark:bg-slate-900/60 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 hover:border-blue-500/50 transition flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl"> </span>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-mono">
                                        {{ $minister->country?->name_ar ?? 'الجزائر' }}
                                    </span>
                                </div>
                                
                                <!-- Status Toggle -->
                                <select wire:change="updateMinisterStatus({{ $minister->id }}, $event.target.value)" class="text-[10px] font-black rounded-full px-2.5 py-1 border border-slate-300 dark:border-slate-600 focus:outline-none {{ $minister->availability_status === 'AVAILABLE' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : ($minister->availability_status === 'BUSY' ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300') }}">
                                    <option value="AVAILABLE" {{ $minister->availability_status === 'AVAILABLE' ? 'selected' : '' }}>متاح للقاءات</option>
                                    <option value="BUSY" {{ $minister->availability_status === 'BUSY' ? 'selected' : '' }}>مشغول حالياً</option>
                                    <option value="IN_MEETING" {{ $minister->availability_status === 'IN_MEETING' ? 'selected' : '' }}>في اجتماع مغلق</option>
                                    <option value="OFFLINE" {{ $minister->availability_status === 'OFFLINE' ? 'selected' : '' }}>غير متوفر</option>
                                </select>
                            </div>

                            <div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white">
                                    {{ $minister->full_name }}
                                </h3>
                                <p class="text-xs font-bold text-amber-600 dark:text-amber-400 mt-0.5">
                                    {{ $minister->title_ar }}
                                </p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                    {{ $minister->ministry_name }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-200/60 dark:border-slate-700/60 flex items-center justify-between gap-2">
                            <button wire:click="openBookingModal({{ $minister->id }})" class="flex-1 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-[11px] transition shadow-xs">
                                <svg class="w-3.5 h-3.5 inline-block me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>حجز لقاء
                            </button>
                            <button wire:click="showMinisterCredentials({{ $minister->id }})" class="flex-1 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 dark:bg-blue-950 dark:hover:bg-blue-900 text-blue-700 dark:text-blue-300 font-bold text-[11px] border border-blue-200 dark:border-blue-800 transition">
                                <svg class="w-3.5 h-3.5 inline-block me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>بطاقة SSO
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 text-center text-slate-400 dark:text-slate-500 font-bold">
                        لا يوجد وزراء أو مسؤولون مطابقون لخيارات البحث.
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- TAB 3: VIP ROOMS -->
    @if(($activeTab ?? 'MEETINGS') === 'ROOMS')
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs overflow-hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($rooms as $room)
                    <div class="bg-slate-50 dark:bg-slate-900/60 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 hover:border-purple-500/50 transition flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="w-10 h-10 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg></div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300 border border-purple-300 dark:border-purple-800">
                                    السعة: {{ $room->capacity }} مقعد VIP
                                </span>
                            </div>

                            <div>
                                <h3 class="text-base font-black text-slate-900 dark:text-white">
                                    {{ $room->name_ar }}
                                </h3>
                                <p class="text-xs font-mono text-slate-400 mt-0.5">
                                    {{ $room->name_fr ?: $room->name_en }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-600 dark:text-slate-400 flex-wrap">
                                <span class="px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-700"><svg class="w-3 h-3 text-slate-500 inline-block me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>ترجمة فورية</span>
                                <span class="px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-700"><svg class="w-3 h-3 text-slate-500 inline-block me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>خط مشفر</span>
                                <span class="px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-700"><svg class="w-3 h-3 text-slate-500 inline-block me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>بث صحفي</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-200/60 dark:border-slate-700/60">
                            <button wire:click="openBookingModal(null, {{ $room->id }})" class="w-full py-2.5 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white font-black text-xs transition shadow-lg shadow-purple-600/20">
                                حجز هذه القاعة الآن
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 text-center text-slate-400 dark:text-slate-500 font-bold">
                        لا توجد قاعات VIP مسجلة حالياً.
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- BOOKING MODAL -->
    @if($showBookingModal ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs transition-all">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 space-y-5 border border-slate-200 dark:border-slate-700 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span><svg class="w-3.5 h-3.5 inline-block me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>حجز لقاء ثنائي وتأكيد موعد VIP</span>
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                @if(!empty($errorMessage))
                    <div class="p-3 bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 rounded-xl text-xs font-bold text-rose-700 dark:text-rose-300">
                        {{ $errorMessage }}
                    </div>
                @endif

                <form wire:submit.prevent="createBilateralMeeting" class="space-y-4 text-xs font-bold">
                    <!-- Host Minister -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">الطرف المضيف (الجزائر) *</label>
                        <select wire:model="hostMinisterId" required class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">اختر الوزير المضيف...</option>
                            @foreach($ministers as $m)
                                <option value="{{ $m->id }}"> {{ $m->full_name }} — {{ $m->title_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Guest Minister -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">الطرف الضيف (الوزير / المسؤول الدولي) *</label>
                        <select wire:model="guestMinisterId" required class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">اختر الوزير الضيف...</option>
                            @foreach($ministers as $m)
                                <option value="{{ $m->id }}"> {{ $m->full_name }} — {{ $m->country?->name_ar }} ({{ $m->title_ar }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Room Selection -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">قاعة اللقاء VIP *</label>
                        <select wire:model="roomId" required class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option value="">اختر القاعة...</option>
                            @foreach($rooms as $rm)
                                <option value="{{ $rm->id }}">{{ $rm->name_ar }} (سعة: {{ $rm->capacity }} مقعد)</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Title & Purpose -->
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">عنوان اللقاء *</label>
                        <input type="text" wire:model="meetingTitle" required placeholder="مثال: جلسة عمل ثنائية لتطوير التكوين المهني" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <!-- Date & Times -->
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">التاريخ *</label>
                            <input type="date" wire:model="meetingDate" required class="w-full px-3 py-2 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white text-center focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">وقت البداية *</label>
                            <input type="time" wire:model="startTime" required class="w-full px-3 py-2 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white text-center focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">وقت النهاية *</label>
                            <input type="time" wire:model="endTime" required class="w-full px-3 py-2 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white text-center focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                        <button type="button" wire:click="closeModal" class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-2xl">إلغاء</button>
                        <button type="submit" class="px-6 py-2.5 text-xs font-black text-white bg-amber-500 hover:bg-amber-600 rounded-2xl shadow-lg shadow-amber-500/20">تأكيد وتثبيت الموعد</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- ADD MINISTER MODAL -->
    @if($showAddMinisterModal ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs transition-all">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 space-y-5 border border-slate-200 dark:border-slate-700 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg><span>إضافة وزير / مسؤول شرفي جديد</span>
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveNewMinister" class="space-y-4 text-xs font-bold">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">دولة / وفد الوزير *</label>
                        <select wire:model="newMinisterCountryId" required class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">اختر الدولة...</option>
                            @foreach($countries as $cnt)
                                <option value="{{ $cnt->id }}"> {{ $cnt->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">الاسم الكامل للوزير/المسؤول *</label>
                        <input type="text" wire:model="newMinisterName" required placeholder="معالي الوزير..." class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الصفة الرسمية (عربي) *</label>
                            <input type="text" wire:model="newMinisterTitleAr" required placeholder="وزير التكوين والتعليم المهنيين" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الوزارة / الهيئة *</label>
                            <input type="text" wire:model="newMinisterMinistry" required placeholder="وزارة التكوين المهني" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">رقم الهاتف للتواصل البروتوكولي</label>
                        <input type="text" wire:model="newMinisterPhone" placeholder="+213..." class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-mono font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" dir="ltr">
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                        <button type="button" wire:click="closeModal" class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-2xl">إلغاء</button>
                        <button type="submit" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-2xl shadow-lg shadow-blue-600/20">حفظ وإنشاء حساب SSO</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- CREDENTIAL PASS MODAL -->
    @if(($showCredentialModal ?? false) && !empty($credentialData))
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-xs transition-all">
            <div class="bg-gradient-to-br from-slate-900 to-slate-950 text-white rounded-3xl max-w-md w-full p-6 space-y-6 border border-amber-500/40 shadow-2xl relative overflow-hidden">
                <!-- Watermark -->
                

                <div class="flex items-center justify-between border-b border-amber-500/20 pb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></div>
                        <div>
                            <h3 class="text-base font-black text-amber-400">بطاقة اعتماد ورسالة الدخول الموحد SSO</h3>
                            <p class="text-[10px] text-slate-400 font-mono">WorldSkills Africa Protocol System</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-white p-1 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Credential Card -->
                <div class="bg-slate-800/80 p-5 rounded-2xl border border-slate-700/80 space-y-3 text-xs">
                    <div class="flex justify-between items-center"><span class="text-slate-400">الاسم واللقب:</span><span class="font-black text-amber-300 text-sm">{{ $credentialData['name'] }}</span></div>
                    <div class="flex justify-between items-center"><span class="text-slate-400">الصفة الرسمية:</span><span class="font-bold text-slate-200">{{ $credentialData['title'] }}</span></div>
                    <div class="flex justify-between items-center"><span class="text-slate-400">الدولة / الوفد:</span><span class="font-bold text-blue-400 font-mono">{{ $credentialData['country'] }} ({{ $credentialData['country_code'] }})</span></div>
                    <hr class="border-slate-700/60">
                    <div class="flex justify-between items-center"><span class="text-slate-400">البريد الإلكتروني للقرين:</span><span class="font-mono font-bold text-emerald-400 dir-ltr select-all">{{ $credentialData['email'] }}</span></div>
                    <div class="flex justify-between items-center"><span class="text-slate-400">كلمة المرور الأولية:</span><span class="font-mono font-bold text-amber-400 dir-ltr select-all">{{ $credentialData['password'] }}</span></div>
                </div>

                <div class="flex justify-center pt-2">
                    <button onclick="window.print()" class="w-full py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs transition shadow-lg shadow-amber-500/20">
                        <svg class="w-4 h-4 inline-block me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>طباعة بطاقة اعتماد الدخول الموحد
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
