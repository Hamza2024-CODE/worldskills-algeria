@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- TOP COMMAND HEADER --}}
    <x-dashboard.page-header
        :title="$t('غرفة القيادة والعمليات الميدانية المباشرة', 'Centre de Commandement des Opérations sur le Terrain', 'Live Field Operations Command Center')"
        :subtitle="$t('متابعة حية وشاملة لقرارات الوصول للشارات، الإطعام، الإقامة، النقل، الأمان الميداني، والتنظيم المباشر.', 'Suivi en temps réel de la logistique, restauration, transport et sécurité sur le terrain.', 'Real-time tracking of logistics, meals, transport, housing, and field security.')"
    >
        <button wire:click="$set('showEmergencyModal', true)" class="px-5 py-2.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs transition shadow-lg flex items-center gap-2 border border-rose-400/30 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>{{ $t('التحكم بالطوارئ', 'Contrôle d\'Urgence', 'Emergency Control') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- FLASH MESSAGE --}}
    @if($flashMessage ?? null)
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold shadow-sm">
        ✓ {{ $flashMessage }}
    </div>
    @endif

    {{-- EMERGENCY LOCKDOWN ACTIVE ALERT BANNER --}}
    @if($activeLockdowns->isNotEmpty())
    <div class="p-5 rounded-3xl bg-rose-600 text-white shadow-xl space-y-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-white animate-ping"></span>
                <h3 class="text-sm font-black uppercase tracking-wider">
                    {{ $t('وضع الإغلاق الأمني الميداني للطوارئ مفعّل حالياً!', 'Mode Verrouillage d\'Urgence Actif!', 'Emergency Field Lockdown Active!') }}
                </h3>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($activeLockdowns as $lock)
            <div class="p-3 rounded-2xl bg-rose-700/60 border border-rose-400/30 flex items-center justify-between text-xs font-bold">
                <div>
                    <span class="font-black text-white block">{{ $lock->title_ar }}</span>
                    <span class="text-[10px] text-rose-200 block">{{ $lock->reason_ar }}</span>
                </div>
                <button wire:click="liftLockdown({{ $lock->id }})" class="px-3 py-1 rounded-xl bg-white text-rose-700 font-black text-[10px] hover:bg-rose-50 transition shadow-sm">
                    {{ $t('رفع الإغلاق', 'Lever le Verrouillage', 'Lift Lockdown') }}
                </button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- LIVE OPERATIONS METRICS GRID --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">وصول مقبول اليوم (ALLOW)</div>
                <div class="text-2xl font-black text-emerald-600">{{ number_format($allowedToday) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">عمليات مرفوضة (DENY)</div>
                <div class="text-2xl font-black text-rose-600">{{ number_format($deniedToday) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">وجبات مستهلكة اليوم</div>
                <div class="text-2xl font-black text-slate-900">{{ number_format($todayMealScans) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">إشعارات مستلمة / مقروءة</div>
                <div class="text-xl font-black text-slate-900">{{ number_format($readCount) }} / {{ number_format($deliveredCount) }}</div>
            </div>
        </div>
    </div>

    {{-- LIVE ACCESS DECISION FEED TICKER --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                <h3 class="text-base font-black text-[#06205C]">شريط البث المباشر لقرارات الوصول للشارات (Live Access Activity Feed)</h3>
            </div>
            <span class="text-xs text-slate-400 font-mono font-bold">تحديث حي ومباشر</span>
        </div>

        <div class="space-y-2">
            @forelse($recentDecisions as $dec)
                @php
                    $isAllow = $dec->decision === 'ALLOW';
                    $badgeStyle = $isAllow 
                        ? 'bg-emerald-50 text-emerald-800 border-emerald-200' 
                        : 'bg-rose-50 text-rose-800 border-rose-200';
                @endphp
                <div class="p-3.5 rounded-2xl border text-xs font-bold flex items-center justify-between transition hover:shadow-xs {{ $badgeStyle }}">
                    <div class="flex items-center gap-3">
                        <span class="font-mono text-[11px] px-2 py-0.5 rounded-lg bg-white/80 font-black">
                            {{ $dec->scanned_at->format('H:i:s') }}
                        </span>

                        <span class="font-black text-slate-900">
                            {{ $isAllow ? '🟢 ALLOW' : '🔴 DENY' }}
                        </span>

                        <span class="font-mono text-slate-600 font-bold">
                            {{ $dec->badge?->badge_uuid ?: 'WSAP-BADGE' }}
                        </span>

                        <span class="text-slate-500 font-medium">
                            ({{ $dec->service_type }})
                        </span>

                        <span class="text-slate-700 font-bold">
                            {{ $dec->reason_message_ar }}
                        </span>
                    </div>

                    <span class="font-mono text-[10px] text-slate-400 uppercase font-black">
                        CODE: {{ $dec->reason_code }}
                    </span>
                </div>
            @empty
                <div class="p-6 text-center text-slate-400 text-xs font-bold">
                    لم تسجل أي عمليات مسح حديثة بعد. استخدم الماسح الموحد لبدء العمليات الميدانية.
                </div>
            @endforelse
        </div>
    </div>

    {{-- EMERGENCY CONTROL MODAL --}}
    @if($showEmergencyModal ?? false)
    <div class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-black text-rose-700">تفعيل وضع الإغلاق الأمني الميداني للطوارئ</h3>
                <button wire:click="$set('showEmergencyModal', false)" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">نطاق الإغلاق الأمني *</label>
                    <select wire:model="lockdown_scope" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold bg-slate-50">
                        <option value="ZONE">📍 منطقة مخصصة (Zone)</option>
                        <option value="MEAL_SLOT">🍽️ مطعم / وجبة محددة</option>
                        <option value="COMPETITION_HALL">🏆 قاعة تنافسية</option>
                        <option value="ALL_MEALS">🔴 إغلاق جميع الوجبات والمطاعم</option>
                        <option value="ALL_TRANSPORT">🔴 إغلاق جميع رحلات النقل</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">معرف الهدف (ID) إن وجد</label>
                    <input type="text" wire:model="target_id" placeholder="مثال: 1 أو ZONE-A" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">عنوان التنبيه الأمني *</label>
                    <input type="text" wire:model="title_ar" required placeholder="مثال: إغلاق أمني طارئ للقاعة C" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">السبب الإلزامي للتفعيل *</label>
                    <textarea wire:model="reason_ar" required rows="3" placeholder="اكتب سبب تفعيل الإغلاق الأمني لتسجيله في سجلات التدقيق..." class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button wire:click="$set('showEmergencyModal', false)" type="button" class="px-4 py-2 rounded-xl bg-slate-100 font-bold text-xs">إلغاء</button>
                <button wire:click="initiateLockdown" type="button" class="px-5 py-2 rounded-xl bg-rose-600 text-white font-black text-xs shadow-md">تأكيد وتفعيل الإغلاق الفوري 🚨</button>
            </div>
        </div>
    </div>
    @endif

</div>
