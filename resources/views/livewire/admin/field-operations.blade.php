@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
$hasActiveLockdown = $activeLockdowns->count() > 0;
@endphp

<div class="space-y-8 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ═════════════════════════════════════════════════════════════════════
         1. EXECUTIVE ROYAL OPERATIONS BANNER
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-slate-800">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 {{ $hasActiveLockdown ? 'bg-rose-600/20' : 'bg-emerald-500/10' }} rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $hasActiveLockdown ? 'bg-rose-950/80 border-rose-800 text-rose-400' : 'bg-emerald-950/80 border-emerald-800 text-emerald-400' }} border text-xs font-mono font-bold">
                    <span class="w-2 h-2 rounded-full {{ $hasActiveLockdown ? 'bg-rose-400 animate-ping' : 'bg-emerald-400 animate-pulse' }}"></span>
                    <span>{{ $hasActiveLockdown ? 'تنبيه: يوجد إغلاق أمني نشط' : 'الحالة الميدانية: مستقرة وجارية' }}</span>
                </div>
                
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    مركز قيادة العمليات والجهوزية الميدانية
                </h1>
                
                <p class="text-xs sm:text-sm text-slate-300 font-bold max-w-2xl">
                    غرفة المراقبة والتحكم المباشر لقراءات الشارات الذكية، نقاط الوصول الميدانية، خدمات الإطعام، الأجندة اليومية، وبروتوكول الطوارئ لأولمبياد المهن 2026.
                </p>
            </div>

            {{-- Quick Operations Action Hub --}}
            <div class="flex items-center flex-wrap gap-3 shrink-0">
                <button 
                    wire:click="$set('showEmergencyModal', true)" 
                    class="px-5 py-3 rounded-2xl bg-rose-600 hover:bg-rose-500 text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center gap-2 border border-rose-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>تفعيل إغلاق طارئ</span>
                </button>

                <button 
                    wire:click="$set('showNotificationModal', true)" 
                    class="px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center gap-2 border border-blue-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span>إرسال تنبيه ميداني</span>
                </button>

                <a 
                    href="{{ route('scan') }}" 
                    target="_blank"
                    class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center gap-2 border border-emerald-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>الماسح الموحد QR</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         2. ACTION FEEDBACK NOTIFICATION BANNER
    ═════════════════════════════════════════════════════════════════════ --}}
    @if($flashMessage)
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $flashMessage }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="text-xs text-slate-400 hover:text-slate-600">إغلاق ✕</button>
        </div>
    @endif

    {{-- ═════════════════════════════════════════════════════════════════════
         3. CORE OPERATIONAL METRICS GRID
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-slate-500 dark:text-slate-400 block uppercase">مسحات الشارات اليوم</span>
            <span class="text-2xl font-black text-slate-900 dark:text-white tracking-tight block">{{ number_format($allowedToday + $deniedToday) }}</span>
            <span class="text-[11px] font-bold text-slate-400 block">إجمالي محاولات الدخول</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 block uppercase">دخول مقبول (ALLOW)</span>
            <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight block">{{ number_format($allowedToday) }}</span>
            <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-500 block">تصريح دخول مؤكد اليوم</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-rose-600 dark:text-rose-400 block uppercase">محاولات مرفوضة (DENY)</span>
            <span class="text-2xl font-black text-rose-600 dark:text-rose-400 tracking-tight block">{{ number_format($deniedToday) }}</span>
            <span class="text-[11px] font-bold text-rose-700 dark:text-rose-500 block">تم منعها أمنياً</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-amber-600 dark:text-amber-400 block uppercase">وجبات مسهلكة اليوم</span>
            <span class="text-2xl font-black text-amber-600 dark:text-amber-400 tracking-tight block">{{ number_format($todayMealScans) }}</span>
            <span class="text-[11px] font-bold text-amber-700 dark:text-amber-500 block">فترات مفتوحة: {{ $activeMealSlots }}</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-purple-600 dark:text-purple-400 block uppercase">إغلاقات الطوارئ</span>
            <span class="text-2xl font-black {{ $hasActiveLockdown ? 'text-rose-600 animate-pulse' : 'text-purple-600 dark:text-purple-400' }} tracking-tight block">{{ number_format($activeLockdowns->count()) }}</span>
            <span class="text-[11px] font-bold text-purple-700 dark:text-purple-500 block">{{ $hasActiveLockdown ? 'يوجد حظر نشط' : 'لا يوجد إغلاق طارئ' }}</span>
        </div>

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         4. INTERACTIVE OPERATIONAL COMMAND TABS
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        
        {{-- Navigation Tabs Header --}}
        <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 p-3 bg-slate-50 dark:bg-slate-900/60 overflow-x-auto">
            <button 
                wire:click="setTab('access_logs')" 
                class="px-5 py-2.5 rounded-2xl text-xs font-black transition whitespace-nowrap flex items-center gap-2 {{ $activeTab === 'access_logs' ? 'bg-slate-950 text-white dark:bg-white dark:text-slate-950 shadow-md' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>البث الحي لقرارات الدخول بالشارات</span>
            </button>

            <button 
                wire:click="setTab('catering')" 
                class="px-5 py-2.5 rounded-2xl text-xs font-black transition whitespace-nowrap flex items-center gap-2 {{ $activeTab === 'catering' ? 'bg-slate-950 text-white dark:bg-white dark:text-slate-950 shadow-md' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span>إدارة الإطعام والمطاعم الميدانية ({{ $activeMealSlots }} مفتوحة)</span>
            </button>

            <button 
                wire:click="setTab('events')" 
                class="px-5 py-2.5 rounded-2xl text-xs font-black transition whitespace-nowrap flex items-center gap-2 {{ $activeTab === 'events' ? 'bg-slate-950 text-white dark:bg-white dark:text-slate-950 shadow-md' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                <span>الأجندة والفعاليات الميدانية ({{ $todayEvents->count() }})</span>
            </button>

            <button 
                wire:click="setTab('emergency')" 
                class="px-5 py-2.5 rounded-2xl text-xs font-black transition whitespace-nowrap flex items-center gap-2 {{ $activeTab === 'emergency' ? 'bg-rose-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                <span>بروتوكول الطوارئ والإغلاق ({{ $activeLockdowns->count() }})</span>
            </button>
        </div>

        {{-- TAB CONTENT AREA --}}
        <div class="p-6 space-y-6">

            {{-- ─────────────────────────────────────────────────────────────
                 TAB 1: LIVE ACCESS FEED & BADGE SCANS
            ───────────────────────────────────────────────────────────── --}}
            @if($activeTab === 'access_logs')
                
                <div class="space-y-4">
                    
                    {{-- Access Log Filter Controls --}}
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-700">
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <span class="text-xs font-bold text-slate-500">تصفية حسب القرار:</span>
                            <select wire:model.live="decisionFilter" class="px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold">
                                <option value="ALL">جميع القرارات (ALLOW + DENY)</option>
                                <option value="ALLOW">المقبولة فقط (ALLOW)</option>
                                <option value="DENY">المرفوضة فقط (DENY)</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <span class="text-xs font-bold text-slate-500">تصفية حسب الخدمة:</span>
                            <select wire:model.live="serviceFilter" class="px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold">
                                <option value="ALL">جميع الخدمات الميدانية</option>
                                <option value="CHECKPOINT">نقاط الوصول (Checkpoint)</option>
                                <option value="RESTAURANT">خدمات الإطعام (Restaurant)</option>
                                <option value="ZONE">المناطق والأجنحة (Zone)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Access Stream Feed List --}}
                    <div class="space-y-2.5">
                        @forelse($recentDecisions as $dec)
                            @php
                                $isAllow = $dec->decision === 'ALLOW';
                                $badgeStyle = $isAllow 
                                    ? 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-200 dark:border-emerald-800/60' 
                                    : 'bg-rose-50 dark:bg-rose-950/40 border-rose-200 dark:border-rose-800/60';
                            @endphp
                            
                            <div class="p-4 rounded-2xl border text-xs font-bold flex flex-col sm:flex-row sm:items-center justify-between gap-3 transition hover:shadow-xs {{ $badgeStyle }}">
                                <div class="flex items-center gap-3">
                                    <span class="font-mono text-[11px] px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 font-black text-slate-700 dark:text-slate-300 shadow-xs shrink-0">
                                        {{ $dec->scanned_at ? $dec->scanned_at->format('H:i:s') : '00:00:00' }}
                                    </span>

                                    <span class="px-3 py-1 rounded-xl font-black text-xs shrink-0 {{ $isAllow ? 'bg-emerald-600 text-white' : 'bg-rose-600 text-white' }}">
                                        {{ $isAllow ? 'مسموح (ALLOW)' : 'مرفوض (DENY)' }}
                                    </span>

                                    <div class="space-y-0.5">
                                        <span class="font-mono font-black text-slate-900 dark:text-white text-xs block">
                                            {{ $dec->badge?->badge_uuid ?? 'WSAP-BADGE-SCAN' }}
                                        </span>
                                        <span class="text-[11px] text-slate-500 font-bold block">
                                            السبب: {{ $dec->reason_message_ar ?? 'عملية مسح اعتيادية' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 text-end shrink-0">
                                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 font-mono font-bold text-[10px]">
                                        {{ $dec->service_type ?? 'CHECKPOINT' }}
                                    </span>
                                    <span class="text-[10px] font-mono text-slate-400 font-bold">
                                        CODE: {{ $dec->reason_code ?? 'OK' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-400 text-xs font-bold bg-slate-50 dark:bg-slate-900/40 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800">
                                لم تسجل أي عمليات مسح مطابقة للمحددات المحددة. استخدم الماسح الموحد لبدء تسجيل عمليات الدخول الحية.
                            </div>
                        @endforelse
                    </div>

                    {{-- Operations Explainer Box --}}
                    <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/60 text-xs font-bold text-blue-900 dark:text-blue-300 space-y-1">
                        <h4 class="font-black text-sm text-blue-900 dark:text-white">كيف يعمل البث الحي لقرارات الوصول؟</h4>
                        <p>
                            تقوم الماسحات الموحدة (QR Scanners) والمشرفون الميدانيون بقرص شارات المترشحين، المنظمين، والخبراء عند بوابة الوصول أو القاعات. يقوم النظام آلياً للتحقق من صلاحية الشارة، المنطقة المسموحة، وحالة التفعيل وتسجيل القرار فورا في هذا البث الحي.
                        </p>
                    </div>

                </div>

            @endif

            {{-- ─────────────────────────────────────────────────────────────
                 TAB 2: CATERING & RESTAURANT LOGISTICS
            ───────────────────────────────────────────────────────────── --}}
            @if($activeTab === 'catering')
                
                <div class="space-y-6">
                    
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white">فترات الإطعام والمطاعم الميدانية النشطة</h3>
                            <p class="text-xs text-slate-500 font-bold mt-0.5">تحكم مباشر في فتح وإغلاق وجبات الإفطار والغداء والعشاء للوفود</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($mealSlots as $slot)
                            <div class="p-5 rounded-3xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 space-y-4 shadow-sm">
                                
                                <div class="flex items-center justify-between">
                                    <div class="space-y-1">
                                        <span class="px-2.5 py-1 rounded-lg bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300 font-mono font-black text-xs">
                                            {{ $slot->meal_type }}
                                        </span>
                                        <h4 class="font-black text-slate-900 dark:text-white text-base mt-1">
                                            {{ $slot->restaurant?->name_ar ?? 'المطعم الرئيسي بقرية أولمبياد المهن' }}
                                        </h4>
                                    </div>

                                    <span class="px-3 py-1 rounded-full text-xs font-black {{ $slot->is_open ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                                        {{ $slot->is_open ? 'مفتوح للوجبات ✓' : 'مغلق حالياً ✕' }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between text-xs font-bold pt-2 border-t border-slate-200/60 dark:border-slate-800">
                                    <span class="text-slate-500">استهلاك اليوم: <strong class="text-slate-900 dark:text-white font-mono text-sm">{{ number_format($todayMealScans) }}</strong> وجبة</span>
                                    
                                    <button 
                                        wire:click="toggleMealSlot({{ $slot->id }})" 
                                        class="px-4 py-2 rounded-xl text-xs font-black transition {{ $slot->is_open ? 'bg-rose-600 hover:bg-rose-500 text-white' : 'bg-emerald-600 hover:bg-emerald-500 text-white' }}">
                                        {{ $slot->is_open ? 'إغلاق فترة الإطعام' : 'فتح فترة الإطعام الان' }}
                                    </button>
                                </div>

                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-400 text-xs font-bold bg-slate-50 dark:bg-slate-900/40 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800 col-span-2">
                                لا توجد فترات إطعام مسجلة بالنظام حالياً.
                            </div>
                        @endforelse
                    </div>

                    {{-- Operations Explainer Box --}}
                    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-xs font-bold text-amber-900 dark:text-amber-300 space-y-1">
                        <h4 class="font-black text-sm text-amber-900 dark:text-white">كيف تدار عمليات الإطعام والمطاعم الميدانية؟</h4>
                        <p>
                            عند وصول المشارك إلى المطعم، يتم مسح الشارة الذكية بواسطة الماسح الموحد. يستعلم النظام فوراً للتأكد من أن فترة الإطعام مفتوحة وأن المشارك لم يستكفِ بوجبته بعد، وذلك لمنع التكرار وضمان توزيع الوجبات على كافة الوفود بسلاسة ونظام.
                        </p>
                    </div>

                </div>

            @endif

            {{-- ─────────────────────────────────────────────────────────────
                 TAB 3: LIVE EVENTS & SCHEDULE MONITORING
            ───────────────────────────────────────────────────────────── --}}
            @if($activeTab === 'events')
                
                <div class="space-y-6">
                    
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white">جدول الأجندة والفعاليات الميدانية</h3>
                            <p class="text-xs text-slate-500 font-bold mt-0.5">متابعة مواعيد التنافس، الندوات، وحفلات الافتتاح والاختتام</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @forelse($todayEvents as $evt)
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
                                
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300 font-mono font-black text-[10px]">
                                            {{ $evt->start_at ? $evt->start_at->format('H:i') : '09:00' }} - {{ $evt->end_at ? $evt->end_at->format('H:i') : '18:00' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-[10px]">
                                            {{ $evt->location ?? 'الموقع الرئيسي' }}
                                        </span>
                                    </div>

                                    <h4 class="font-black text-slate-900 dark:text-white text-sm">
                                        {{ $evt->title_ar }}
                                    </h4>
                                </div>

                                <span class="px-3 py-1 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 font-bold text-xs shrink-0">
                                    مجدولة ونشطة
                                </span>

                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-400 text-xs font-bold bg-slate-50 dark:bg-slate-900/40 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800">
                                لا توجد فعاليات مجدولة لهذا اليوم بالتحديد.
                            </div>
                        @endforelse
                    </div>

                </div>

            @endif

            {{-- ─────────────────────────────────────────────────────────────
                 TAB 4: EMERGENCY PROTOCOL & LOCKDOWN COMMAND
            ───────────────────────────────────────────────────────────── --}}
            @if($activeTab === 'emergency')
                
                <div class="space-y-6">
                    
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                        <div>
                            <h3 class="text-base font-black text-rose-600">بروتوكول الطوارئ والإغلاق الأمني الميداني</h3>
                            <p class="text-xs text-slate-500 font-bold mt-0.5">الحظر الفوري لحركة المرور والدخول في الحالات الطارئة</p>
                        </div>

                        <button 
                            wire:click="$set('showEmergencyModal', true)" 
                            class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-black text-xs shadow-md">
                            + تفعيل حظر جديد
                        </button>
                    </div>

                    {{-- Active Lockdowns List --}}
                    <div class="space-y-3">
                        @forelse($activeLockdowns as $lock)
                            <div class="p-5 rounded-3xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
                                
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-0.5 rounded-lg bg-rose-600 text-white font-mono font-black text-[10px]">
                                            SCOPE: {{ $lock->scope }}
                                        </span>
                                        <span class="text-rose-700 dark:text-rose-400 font-mono font-bold text-[10px]">
                                            تاريخ التفعيل: {{ $lock->created_at?->diffForHumans() }}
                                        </span>
                                    </div>

                                    <h4 class="font-black text-rose-900 dark:text-white text-base mt-1">
                                        {{ $lock->title_ar }}
                                    </h4>

                                    <p class="text-xs text-rose-700 dark:text-rose-300 font-bold">
                                        السبب: {{ $lock->reason_ar }}
                                    </p>
                                </div>

                                <button 
                                    wire:click="liftLockdown({{ $lock->id }})" 
                                    class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs shadow-md shrink-0">
                                    رفع الحظر وإلغاء الإغلاق
                                </button>

                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-500 dark:text-slate-400 text-xs font-bold bg-emerald-50 dark:bg-emerald-950/30 rounded-2xl border border-emerald-200 dark:border-emerald-800">
                                🌿 لا يوجد أي وضع إغلاق أمني نشط حالياً. جميع المنافذ والخدمات الميدانية تعمل بشكل اعتيادي وآمن.
                            </div>
                        @endforelse
                    </div>

                    {{-- Operations Explainer Box --}}
                    <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 text-xs font-bold text-rose-900 dark:text-rose-300 space-y-1">
                        <h4 class="font-black text-sm text-rose-900 dark:text-white">ما هو بروتوكول الإغلاق الأمني الميداني؟</h4>
                        <p>
                            يستخدم زر الطوارئ لإيقاف كافة عمليات المسح والدخول فورياً في قاعة معينة، أو مطعم محدد، أو عبر كامل القطاع الميداني في حالات الطوارئ. عند تفعيل الحظر، ترفض كافة الماسحات الموحدة محاولات الدخول آلياً (DENY) مع تسجيل السبب في سجل التدقيق الميداني.
                        </p>
                    </div>

                </div>

            @endif

        </div>

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         5. EMERGENCY CONTROL MODAL
    ═════════════════════════════════════════════════════════════════════ --}}
    @if($showEmergencyModal)
    <div class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-base font-black text-rose-600">تفعيل وضع الإغلاق الأمني الميداني للطوارئ</h3>
                <button wire:click="$set('showEmergencyModal', false)" class="text-slate-400 hover:text-slate-600 text-sm font-black">✕</button>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">نطاق الإغلاق الأمني *</label>
                    <select wire:model="lockdown_scope" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                        <option value="ZONE">منطقة مخصصة (Zone)</option>
                        <option value="MEAL_SLOT">مطعم / وجبة محددة</option>
                        <option value="COMPETITION_HALL">قاعة تنافسية</option>
                        <option value="ALL_MEALS">إغلاق جميع الوجبات والمطاعم</option>
                        <option value="ALL_TRANSPORT">إغلاق جميع رحلات النقل</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">معرف الهدف (ID) إن وجد</label>
                    <input type="text" wire:model="target_id" placeholder="مثال: 1 أو ZONE-A" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">عنوان التنبيه الأمني *</label>
                    <input type="text" wire:model="title_ar" required placeholder="مثال: إغلاق أمني طارئ للقاعة C" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">السبب الإلزامي للتفعيل *</label>
                    <textarea wire:model="reason_ar" required rows="3" placeholder="اكتب سبب تفعيل الإغلاق الأمني لتسجيله في سجلات التدقيق..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                <button wire:click="$set('showEmergencyModal', false)" type="button" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 font-bold text-xs text-slate-700 dark:text-slate-300">إلغاء</button>
                <button wire:click="initiateLockdown" type="button" class="px-5 py-2.5 rounded-xl bg-rose-600 text-white font-black text-xs shadow-md">تأكيد وتفعيل الإغلاق الفوري</button>
            </div>
        </div>
    </div>
    @endif

    {{-- ═════════════════════════════════════════════════════════════════════
         6. FIELD NOTIFICATION ALERT MODAL
    ═════════════════════════════════════════════════════════════════════ --}}
    @if($showNotificationModal)
    <div class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-base font-black text-blue-600">إرسال تنبيه ميداني مباشر للمستخدمين والمنظمين</h3>
                <button wire:click="$set('showNotificationModal', false)" class="text-slate-400 hover:text-slate-600 text-sm font-black">✕</button>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">أولوية التنبيه *</label>
                    <select wire:model="notif_priority" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                        <option value="HIGH">عالية جداً (High / Emergency)</option>
                        <option value="NORMAL">عادية (Normal)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">عنوان التنبيه الميداني *</label>
                    <input type="text" wire:model="notif_title_ar" required placeholder="مثال: تغيير قاعة افتتاح التنافس" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">نص الرسالة الميدانية *</label>
                    <textarea wire:model="notif_body_ar" required rows="3" placeholder="اكتب نص التنبيه الميداني الموجه لكافة المنظمين والوفود..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                <button wire:click="$set('showNotificationModal', false)" type="button" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 font-bold text-xs text-slate-700 dark:text-slate-300">إلغاء</button>
                <button wire:click="sendFieldAlert" type="button" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-black text-xs shadow-md">تعميم وإرسال التنبيه</button>
            </div>
        </div>
    </div>
    @endif

</div>
