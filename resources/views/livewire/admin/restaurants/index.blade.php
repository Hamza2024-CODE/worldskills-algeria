@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr' => $fr, 'en' => $en, default => $ar};
@endphp

<div class="space-y-6 p-4 sm:p-6" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Flash Message --}}
    @if(!empty($flashMessage))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         class="flex items-center gap-3 p-4 rounded-2xl {{ $flashType === 'success' ? 'bg-emerald-50 border border-emerald-200 text-emerald-900' : 'bg-amber-50 border border-amber-200 text-amber-900' }} text-sm font-bold shadow-sm">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="flex-1">{{ $flashMessage }}</span>
        <button @click="show = false" class="text-slate-400 hover:text-slate-600">&times;</button>
    </div>
    @endif

    {{-- Header --}}
    <x-dashboard.page-header
        :title="$t('مركز إدارة المطاعم والوجبات والمطابخ', 'Centre de Gestion de Restauration', 'Catering & Meals Management Center')"
        subtitle="WSAP — Catering & Meal Access Control System"
    >
        <button wire:click="exportScansCsv()" class="flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-black text-xs transition backdrop-blur-md shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <span>{{ $t('تصدير السجل CSV', 'Exporter CSV', 'Export CSV Log') }}</span>
        </button>
        <button wire:click="openSlotForm()" class="flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-lg transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $t('إضافة خانة وجبة', 'Ajouter un Créneau', 'Add Meal Slot') }}</span>
        </button>
        <button wire:click="openRestaurantForm()" class="flex items-center gap-1.5 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $t('إضافة مطعم جديد', 'Ajouter un Restaurant', 'Add Restaurant') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- KPI Dashboard --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm text-center">
            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($totalAuthorized) }}</div>
            <div class="text-xs font-bold text-slate-600 dark:text-slate-300 mt-1">{{ $t('مسموح اليوم', 'Autorisés Aujourd’hui', 'Authorized Today') }}</div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm text-center">
            <div class="text-2xl font-black text-rose-600 dark:text-rose-400">{{ number_format($totalDenied) }}</div>
            <div class="text-xs font-bold text-slate-600 dark:text-slate-300 mt-1">{{ $t('مرفوض اليوم', 'Refusés Aujourd’hui', 'Denied Today') }}</div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm text-center">
            <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ number_format($totalDuplicate) }}</div>
            <div class="text-xs font-bold text-slate-600 dark:text-slate-300 mt-1">{{ $t('مكرر اليوم', 'Doublons Aujourd’hui', 'Duplicates Today') }}</div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm text-center">
            <div class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ number_format($todaySlots->count()) }}</div>
            <div class="text-xs font-bold text-slate-600 dark:text-slate-300 mt-1">{{ $t('خانات اليوم', 'Créneaux du Jour', 'Slots Today') }}</div>
        </div>
        <div class="col-span-2 sm:col-span-4 lg:col-span-1 bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm text-center">
            <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ number_format($totalCapacity) }}</div>
            <div class="text-xs font-bold text-slate-600 dark:text-slate-300 mt-1">{{ $t('الطاقة الاستيعابية', 'Capacité Totale', 'Total Capacity') }}</div>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800/60 p-1.5 rounded-2xl overflow-x-auto border border-slate-200/60 dark:border-slate-700">
        @foreach([
            ['scanner',     $t('ماسح الشارات المباشر', 'Scanner Direct', 'Live Badge Scanner'), 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16.97 16.97l2.83 2.83M5 5l14 14'],
            ['restaurants', $t('المطاعم', 'Restaurants', 'Restaurants'), 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5'],
            ['slots',       $t('خانات الوجبات', 'Créneaux Repas', 'Meal Slots'), 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['entitlements',$t('الاستحقاقات', 'Droits & Accès', 'Meal Entitlements'), 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
            ['scans',       $t('سجل المسح', 'Historique Scans', 'Scans Log'), 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2']
        ] as [$tab, $label, $iconPath])
        <button wire:click="$set('activeTab', '{{ $tab }}')"
            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-black whitespace-nowrap transition
                   {{ $activeTab === $tab ? 'bg-white dark:bg-slate-700 text-[#06205C] dark:text-white shadow-sm border border-slate-200/80 dark:border-slate-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/></svg>
            <span>{{ $label }}</span>
        </button>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════════════════
         TAB 1: LIVE SCANNER
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'scanner')
    <div class="space-y-6" x-data="restaurantScanner()" x-init="initScanner()">

        {{-- Slot Selector & Status Topbar --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1 flex-1">
                    <label class="text-xs font-black text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ $t('حدد خانة الوجبة النشطة للمسح:', 'Sélectionnez le créneau actif:', 'Select Active Meal Slot:') }}</span>
                    </label>
                    <select wire:model.live="selectedSlotId" class="w-full sm:max-w-md px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-bold text-xs focus:ring-2 focus:ring-emerald-500">
                        @forelse($openSlotsToday as $slotItem)
                        <option value="{{ $slotItem->id }}">
                            {{ $slotItem->restaurant?->name_ar }} — {{ $slotItem->meal_type }} ({{ $slotItem->start_time }} - {{ $slotItem->end_time }}) [{{ $slotItem->scans()->where('status','AUTHORIZED')->count() }}/{{ $slotItem->max_capacity }}]
                        </option>
                        @empty
                        <option value="">{{ $t('لا توجد خانات وجبات مفتوحة اليوم', 'Aucun créneau ouvert aujourd\'hui', 'No open slots today') }}</option>
                        @endforelse
                    </select>
                </div>

                @if($selectedSlot)
                <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-2xl p-3.5 shrink-0">
                    <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                    <div>
                        <div class="text-xs font-black text-emerald-900 dark:text-emerald-300 flex items-center gap-2">
                            <span>{{ $selectedSlot->restaurant?->name_ar }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-200 dark:bg-emerald-800 text-emerald-900 dark:text-emerald-100">{{ $selectedSlot->meal_type }}</span>
                        </div>
                        <div class="text-[11px] text-emerald-700 dark:text-emerald-400 font-bold mt-0.5">
                            {{ $selectedSlot->start_time }} — {{ $selectedSlot->end_time }} | {{ $t('المسح المصرح:', 'Autorisés:', 'Authorized:') }} {{ $selectedSlot->scans()->where('status','AUTHORIZED')->count() }} / {{ $selectedSlot->max_capacity }}
                        </div>
                    </div>
                    <button wire:click="toggleSlotStatus({{ $selectedSlot->id }})" class="mr-2 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[11px] transition shadow-sm">
                        {{ $selectedSlot->is_open ? $t('إغلاق الخانة', 'Fermer', 'Close') : $t('فتح الخانة', 'Ouvrir', 'Open') }}
                    </button>
                </div>
                @endif
            </div>
        </div>

        {{-- Camera Scanner & Manual Search Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- Camera Scanner Column --}}
            <div class="lg:col-span-7 bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="font-black text-slate-900 dark:text-white text-sm">{{ $t('كاميرا مسح شارات الوجبات', 'Caméra Scan Repas', 'Meal Badge Camera Scanner') }}</h3>
                    </div>

                    <div class="flex items-center gap-2">
                        <button @click="toggleCamera()" 
                                class="px-3.5 py-1.5 rounded-xl font-black text-xs transition flex items-center gap-1.5"
                                :class="cameraActive ? 'bg-rose-100 text-rose-700 hover:bg-rose-200' : 'bg-emerald-600 text-white hover:bg-emerald-700'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span x-text="cameraActive ? '{{ $t('إيقاف الكاميرا', 'Arrêter Caméra', 'Stop Camera') }}' : '{{ $t('تشغيل الكاميرا', 'Démarrer Caméra', 'Start Camera') }}'"></span>
                        </button>
                    </div>
                </div>

                {{-- Live Camera Container --}}
                <div class="relative bg-slate-950 rounded-2xl overflow-hidden min-h-[320px] flex items-center justify-center border border-slate-800 shadow-inner">
                    <div id="meal-qr-reader" class="w-full h-full"></div>

                    <div x-show="!cameraActive" class="text-center p-6 space-y-3">
                        <div class="w-16 h-16 rounded-2xl bg-slate-800/80 text-slate-400 flex items-center justify-center mx-auto border border-slate-700">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16.97 16.97l2.83 2.83M5 5l14 14"/></svg>
                        </div>
                        <p class="text-xs text-slate-400 font-bold max-w-xs mx-auto">
                            {{ $t('انقر فوق زر "تشغيل الكاميرا" لمسح رمز QR المطبوع على شارة المشارك تلقائياً.', 'Cliquez sur Démarrer Caméra pour scanner le QR Code du badge.', 'Click Start Camera to auto scan candidate badge QR code.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Manual Entry & Quick Search Column --}}
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-700">
                        <div class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="font-black text-slate-900 dark:text-white text-sm">{{ $t('إدخال رمز الشارة أو البحث اليدوي', 'Saisie Manuel / Recherche', 'Manual Badge Code Entry') }}</h3>
                    </div>

                    <form wire:submit.prevent="scanMealBadge()" class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-slate-600 dark:text-slate-400 block mb-1.5">
                                {{ $t('أدخل رمز QR الشارة، البريد، أو معرف المشارك:', 'Code Badge, Email ou ID:', 'Enter Badge Code, Email or ID:') }}
                            </label>
                            <input wire:model="scanQuery" type="text" placeholder="مثال: WSAP-2026-DZ-005061 أو e-mail..."
                                   class="w-full px-4 py-3 rounded-2xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white text-sm font-bold focus:ring-2 focus:ring-emerald-500 focus:bg-white" autofocus>
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $t('تحقق وتأكيد استحقاق الوجبة', 'Vérifier l\'Accès Repas', 'Verify Meal Entitlement') }}</span>
                        </button>
                    </form>
                </div>

                {{-- Last Scans Summary Box --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-3">
                    <h4 class="text-xs font-black text-slate-700 dark:text-slate-300 flex items-center justify-between">
                        <span>{{ $t('آخر عمليات المسح اليوم', 'Derniers Scans', 'Recent Scans Today') }}</span>
                        <span class="text-[11px] font-bold text-slate-400">{{ $scansLog->total() }} total</span>
                    </h4>

                    <div class="space-y-2 max-h-48 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($scansLog->take(5) as $scanItem)
                        <div class="pt-2 flex items-center justify-between text-xs">
                            <div>
                                <div class="font-black text-slate-900 dark:text-white">{{ $scanItem->participant_name_snapshot }}</div>
                                <div class="text-[10px] text-slate-400">{{ $scanItem->restaurant_snapshot }} • {{ $scanItem->scanned_at?->format('H:i:s') }}</div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $scanItem->status === 'AUTHORIZED' ? 'bg-emerald-100 text-emerald-700' : ($scanItem->status === 'DUPLICATE' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                {{ $scanItem->status }}
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-4 text-xs text-slate-400 font-bold">{{ $t('لا توجد عمليات مسح مسجلة بعد', 'Aucun scan enregistré', 'No scans recorded yet') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         TAB 2: RESTAURANTS
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'restaurants')
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
            <input wire:model.live.debounce.300ms="search" type="search" placeholder="{{ $t('بحث في المطاعم...', 'Rechercher restaurant...', 'Search restaurants...') }}"
                   class="w-full sm:max-w-xs px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white">
            <select wire:model.live="filterStatus" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white">
                <option value="">{{ $t('كل الحالات', 'Tous les états', 'All Statuses') }}</option>
                <option value="active">{{ $t('مفتوح / نشط', 'Actif', 'Active') }}</option>
                <option value="inactive">{{ $t('مغلق', 'Inactif', 'Inactive') }}</option>
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($restaurants as $r)
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                <div class="p-5 space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-black text-slate-900 dark:text-white text-base">{{ $r->name_ar }}</h3>
                            @if($r->name_fr) <p class="text-xs text-slate-400 font-medium">{{ $r->name_fr }}</p> @endif
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $r->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                            {{ $r->is_active ? $t('مفتوح', 'Actif', 'Active') : $t('مغلق', 'Inactif', 'Inactive') }}
                        </span>
                    </div>

                    @if($r->location)
                    <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 font-medium">
                        <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $r->location }}</span>
                    </div>
                    @endif

                    <div class="flex items-center justify-between text-xs font-bold pt-2 border-t border-slate-100 dark:border-slate-700">
                        <span class="text-slate-600 dark:text-slate-400">{{ $t('الطاقة:', 'Capacité:', 'Capacity:') }} <strong class="text-slate-900 dark:text-white">{{ number_format($r->capacity) }}</strong></span>
                        <span class="text-blue-600 dark:text-blue-400">{{ $r->meal_slots_count }} {{ $t('خانات وجبات', 'créneaux', 'slots') }}</span>
                    </div>
                </div>

                {{-- Card Actions --}}
                <div class="bg-slate-50 dark:bg-slate-900/50 px-5 py-3 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between gap-2">
                    <button wire:click="openSlotForm({{ $r->id }})" class="px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 dark:bg-blue-950 dark:hover:bg-blue-900 text-blue-700 dark:text-blue-300 font-black text-xs transition">
                        + {{ $t('إضافة وجبة', 'Créneau', 'Add Slot') }}
                    </button>
                    <div class="flex items-center gap-1">
                        <button wire:click="openRestaurantForm({{ $r->id }})" class="p-1.5 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button wire:click="confirmDelete('restaurant', {{ $r->id }})" class="p-1.5 rounded-xl hover:bg-rose-100 text-rose-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white dark:bg-slate-800 rounded-3xl p-12 text-center border border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-500 dark:text-slate-400 font-bold">{{ $t('لا يوجد مطاعم مسجلة بعد.', 'Aucun restaurant trouvé.', 'No restaurants found.') }}</p>
            </div>
            @endforelse
        </div>

        <div class="mt-4">{{ $restaurants->links() }}</div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         TAB 3: MEAL SLOTS
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'slots')
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <input wire:model.live="filterDate" type="date" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white">
                <select wire:model.live="filterMeal" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white">
                    <option value="">{{ $t('جميع الوجبات', 'Toutes les repas', 'All Meal Types') }}</option>
                    <option value="BREAKFAST">فطور الصباح</option>
                    <option value="LUNCH">غداء</option>
                    <option value="DINNER">عشاء</option>
                    <option value="SNACK">وجبة خفيفة</option>
                </select>
            </div>

            <button wire:click="openSlotForm()" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs transition shadow-sm">
                + {{ $t('إضافة خانة جديدة', 'Nouveau Créneau', 'New Slot') }}
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-900/80 text-slate-600 dark:text-slate-400 font-black border-b border-slate-200 dark:border-slate-700 uppercase">
                        <tr>
                            <th class="p-4">{{ $t('المطعم', 'Restaurant', 'Restaurant') }}</th>
                            <th class="p-4">{{ $t('التاريخ والنوع', 'Date & Type', 'Date & Type') }}</th>
                            <th class="p-4">{{ $t('التوقيت', 'Horaire', 'Time Window') }}</th>
                            <th class="p-4">{{ $t('الاستيعاب والمسح', 'Capacité & Scans', 'Capacity & Scans') }}</th>
                            <th class="p-4">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                            <th class="p-4 text-center">{{ $t('الإجراءات', 'Actions', 'Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-bold text-slate-900 dark:text-slate-100">
                        @forelse($mealSlots as $slot)
                        @php 
                            $scannedCount = $slot->scans()->where('status','AUTHORIZED')->count();
                            $pct = $slot->max_capacity > 0 ? min(100, round(($scannedCount / $slot->max_capacity) * 100)) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition">
                            <td class="p-4">
                                <div class="font-black text-sm text-slate-900 dark:text-white">{{ $slot->restaurant?->name_ar }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ $slot->restaurant?->location }}</div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">
                                        {{ $slot->meal_type }}
                                    </span>
                                    <span class="text-xs text-slate-600 dark:text-slate-400">{{ $slot->date?->format('Y-m-d') }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-slate-700 dark:text-slate-300 font-mono dir-ltr text-right">
                                {{ $slot->start_time }} — {{ $slot->end_time }}
                            </td>
                            <td class="p-4 min-w-[160px]">
                                <div class="flex items-center justify-between text-[11px] mb-1">
                                    <span>{{ $scannedCount }} / {{ $slot->max_capacity }}</span>
                                    <span class="text-slate-400">{{ $pct }}%</span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500 {{ $pct > 90 ? 'bg-rose-500' : ($pct > 75 ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ $pct }}%"></div>
                                </div>
                            </td>
                            <td class="p-4">
                                <button wire:click="toggleSlotStatus({{ $slot->id }})" class="px-3 py-1 rounded-full text-[11px] font-black transition {{ $slot->is_open ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                                    {{ $slot->is_open ? $t('مفتوح', 'Ouvert', 'Open') : $t('مغلق', 'Fermé', 'Closed') }}
                                </button>
                            </td>
                            <td class="p-4 text-center space-x-1 space-x-reverse">
                                <button wire:click="grantEntitlementToAllDelegations({{ $slot->id }})" title="منح لكافة الوفود" class="px-2.5 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 font-black text-[11px] transition">
                                    {{ $t('لكافة الوفود', 'Tous Délégués', 'All Delegations') }}
                                </button>
                                <button wire:click="openSlotForm({{ $slot->restaurant_id }}, {{ $slot->id }})" class="p-1.5 rounded-xl hover:bg-slate-100 text-slate-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="confirmDelete('slot', {{ $slot->id }})" class="p-1.5 rounded-xl hover:bg-rose-100 text-rose-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 font-bold">{{ $t('لا توجد خانات وجبات مسجلة بهذا التاريخ.', 'Aucun créneau trouvé.', 'No slots found for this date.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $mealSlots->links() }}</div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         TAB 4: ENTITLEMENTS
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'entitlements')
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <input wire:model.live="filterDate" type="date" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white">
            </div>

            <button wire:click="openEntitlementForm()" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-sm">
                + {{ $t('منح استحقاق وجبة جديد', 'Nouveau Droit Repas', 'New Entitlement') }}
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-900/80 text-slate-600 dark:text-slate-400 font-black border-b border-slate-200 dark:border-slate-700 uppercase">
                        <tr>
                            <th class="p-4">{{ $t('المطعم والخانة', 'Restaurant & Créneau', 'Restaurant & Slot') }}</th>
                            <th class="p-4">{{ $t('المستفيد (وفد / مشارك)', 'Bénéficiaire', 'Beneficiary') }}</th>
                            <th class="p-4">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                            <th class="p-4 text-center">{{ $t('الإجراءات', 'Actions', 'Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-bold text-slate-900 dark:text-slate-100">
                        @forelse($entitlements as $ent)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition">
                            <td class="p-4">
                                <div class="font-black text-sm text-slate-900 dark:text-white">{{ $ent->mealSlot?->restaurant?->name_ar }}</div>
                                <div class="text-[11px] text-emerald-600 dark:text-emerald-400">
                                    {{ $ent->mealSlot?->meal_type }} ({{ $ent->mealSlot?->date?->format('Y-m-d') }})
                                </div>
                            </td>
                            <td class="p-4">
                                @if($ent->country)
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-[10px] font-black">وفد</span>
                                    <span class="font-black text-slate-900 dark:text-white">{{ $ent->country->name_ar }}</span>
                                </div>
                                @elseif($ent->user)
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-950 text-blue-800 dark:text-blue-300 text-[10px] font-black">فردي</span>
                                    <div>
                                        <div class="font-black text-slate-900 dark:text-white">{{ $ent->user->name }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $ent->user->email }}</div>
                                    </div>
                                </div>
                                @else
                                <span class="text-slate-400">غير محدد</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                    {{ $ent->status }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <button wire:click="revokeEntitlement({{ $ent->id }})" class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-black text-[11px] transition">
                                    {{ $t('إلغاء الاستحقاق', 'Révoquer', 'Revoke') }}
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400 font-bold">{{ $t('لا توجد استحقاقات مسجلة.', 'Aucun droit trouvé.', 'No entitlements found.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $entitlements->links() }}</div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         TAB 5: SCANS LOG
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'scans')
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3 w-full sm:w-auto flex-wrap">
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="{{ $t('بحث باسم المشارك أو رمز الشارة...', 'Rechercher nom ou badge...', 'Search name or badge code...') }}"
                       class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white">
                <input wire:model.live="filterDate" type="date" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white">
                <select wire:model.live="filterStatus" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white">
                    <option value="">{{ $t('جميع الحالات', 'Tous les statuts', 'All Statuses') }}</option>
                    <option value="AUTHORIZED">AUTHORIZED (مسموح)</option>
                    <option value="DENIED">DENIED (مرفوض)</option>
                    <option value="DUPLICATE">DUPLICATE (مكرر)</option>
                </select>
            </div>

            <button wire:click="exportScansCsv()" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-900 dark:bg-slate-700 text-white font-black text-xs transition shadow-sm">
                {{ $t('تصدير CSV', 'Exporter CSV', 'Export CSV') }}
            </button>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-900/80 text-slate-600 dark:text-slate-400 font-black border-b border-slate-200 dark:border-slate-700 uppercase">
                        <tr>
                            <th class="p-4">{{ $t('المشارك والدولة', 'Participant & Pays', 'Participant & Country') }}</th>
                            <th class="p-4">{{ $t('رمز الشارة', 'Code Badge', 'Badge Code') }}</th>
                            <th class="p-4">{{ $t('المطعم والوجبة', 'Restaurant & Repas', 'Restaurant & Meal') }}</th>
                            <th class="p-4">{{ $t('النتيجة والسبب', 'Résultat', 'Result') }}</th>
                            <th class="p-4">{{ $t('توقيت المسح', 'Temps', 'Scan Time') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-bold text-slate-900 dark:text-slate-100">
                        @forelse($scansLog as $log)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition">
                            <td class="p-4">
                                <div class="font-black text-slate-900 dark:text-white">{{ $log->participant_name_snapshot }}</div>
                                <div class="text-[10px] text-slate-400">{{ $log->country_snapshot }}</div>
                            </td>
                            <td class="p-4 font-mono text-[11px] text-slate-600 dark:text-slate-300">
                                {{ $log->badge_code }}
                            </td>
                            <td class="p-4">
                                <div class="font-black text-slate-900 dark:text-white">{{ $log->restaurant_snapshot }}</div>
                                <div class="text-[10px] text-emerald-600 dark:text-emerald-400">{{ $log->meal_type_snapshot }}</div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $log->status === 'AUTHORIZED' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : ($log->status === 'DUPLICATE' ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300') }}">
                                    {{ $log->status }}
                                </span>
                                @if($log->denial_reason)
                                <div class="text-[10px] text-rose-600 dark:text-rose-400 mt-1 font-normal">{{ $log->denial_reason }}</div>
                                @endif
                            </td>
                            <td class="p-4 text-slate-600 dark:text-slate-400 text-xs font-mono">
                                {{ $log->scanned_at?->format('H:i:s') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 font-bold">{{ $t('لا توجد عمليات مسح مطابقة.', 'Aucun scan trouvé.', 'No scans found.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $scansLog->links() }}</div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         SCAN RESULT MODAL
    ══════════════════════════════════════════════════════════ --}}
    @if($scanResultModalOpen && !empty($scanResult))
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md animate-fade-in">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-lg w-full border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden p-6 space-y-6 text-center">
            
            {{-- Status Banner & Icon --}}
            @php
                $st = $scanResult['status'] ?? 'DENIED';
                $bgBanner = match($st) {
                    'AUTHORIZED' => 'bg-emerald-500 text-white',
                    'DUPLICATE'  => 'bg-amber-500 text-white',
                    default      => 'bg-rose-600 text-white',
                };
            @endphp
            <div class="p-5 rounded-2xl {{ $bgBanner }} shadow-lg space-y-2">
                <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center mx-auto shadow-inner">
                    @if($st === 'AUTHORIZED')
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    @elseif($st === 'DUPLICATE')
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    @else
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    @endif
                </div>
                <h3 class="text-lg font-black">{{ $scanResult['title'] ?? '' }}</h3>
                <p class="text-xs font-bold text-white/90">{{ $scanResult['message'] ?? '' }}</p>
            </div>

            {{-- Candidate Details Card --}}
            @if(!empty($scanResult['user']))
            @php $u = $scanResult['user']; @endphp
            <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-700 text-right space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-700 dark:text-slate-200 font-black text-base shadow-sm shrink-0">
                        {{ mb_substr($u->name ?? 'P', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-black text-slate-900 dark:text-white text-base truncate">{{ $u->name }}</h4>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-bold truncate">{{ $u->email }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs pt-2 border-t border-slate-200/60 dark:border-slate-700">
                    <div>
                        <span class="text-slate-400 font-bold block text-[10px]">{{ $t('الدولة / الوفد', 'Pays', 'Country') }}:</span>
                        <span class="font-black text-slate-900 dark:text-white">{{ $u->country?->name_ar ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold block text-[10px]">{{ $t('رمز الشارة', 'Code Badge', 'Badge') }}:</span>
                        <span class="font-mono font-bold text-slate-900 dark:text-white text-[11px]">{{ $scanResult['badge']?->badge_uuid ?? 'N/A' }}</span>
                    </div>
                </div>

                {{-- Dietary Requirements Alert --}}
                @if(!empty($scanResult['dietary_list']) || !empty($scanResult['dietary_notes']))
                <div class="mt-3 p-3 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 space-y-1.5">
                    <div class="text-xs font-black text-amber-900 dark:text-amber-300 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>{{ $t('النظام الغذائي وتنبيه الحساسية:', 'Régime Alimentaire & Allergies:', 'Dietary Requirements & Allergies:') }}</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($scanResult['dietary_list'] as $dItem)
                        <span class="px-2 py-0.5 rounded-md bg-amber-200 dark:bg-amber-900 text-amber-900 dark:text-amber-100 font-black text-[10px]">{{ $dItem }}</span>
                        @endforeach
                    </div>
                    @if(!empty($scanResult['dietary_notes']))
                    <p class="text-[11px] font-bold text-amber-800 dark:text-amber-300">{{ $scanResult['dietary_notes'] }}</p>
                    @endif
                </div>
                @endif
            </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 pt-2">
                @if($scanResult['status'] !== 'AUTHORIZED' && !empty($scanResult['user']) && !empty($scanResult['slot']))
                <button wire:click="overrideScan({{ $scanResult['user']->id }}, {{ $scanResult['slot']->id }})" class="flex-1 py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition">
                    {{ $t('منح استثناء يدوي', 'Dérogation Manuel', 'Grant Manual Override') }}
                </button>
                @endif
                <button wire:click="closeScanModal()" class="flex-1 py-3 rounded-2xl bg-slate-900 dark:bg-slate-700 text-white font-black text-xs shadow-md transition">
                    {{ $t('إغلاق / المسح التالي', 'Fermer / Suivant', 'Close / Next Scan') }}
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- RESTAURANT MODAL --}}
    @if($restaurantFormOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full border border-slate-200 dark:border-slate-800 shadow-2xl p-6 space-y-4">
            <h3 class="font-black text-slate-900 dark:text-white text-base pb-3 border-b border-slate-100 dark:border-slate-800">
                {{ $restaurantEditing ? $t('تعديل بيانات المطعم', 'Modifier Restaurant', 'Edit Restaurant') : $t('إضافة مطعم جديد', 'Nouveau Restaurant', 'New Restaurant') }}
            </h3>

            <form wire:submit.prevent="saveRestaurant()" class="space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">اسم المطعم (بالعربية)*</label>
                    <input wire:model="name_ar" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    @error('name_ar') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">الاسم (Français)</label>
                        <input wire:model="name_fr" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">الطاقة الاستيعابية*</label>
                        <input wire:model="capacity" type="number" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                        @error('capacity') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">الموقع / القاعة</label>
                    <input wire:model="location" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input wire:model="is_active" type="checkbox" id="r_active" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500">
                    <label for="r_active" class="text-xs font-bold text-slate-700 dark:text-slate-300">المطعم مفتوح ونشط لاستقبال الوفود</label>
                </div>

                <div class="flex items-center gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-md">
                        {{ $t('حفظ البيانات', 'Enregistrer', 'Save') }}
                    </button>
                    <button type="button" wire:click="$set('restaurantFormOpen', false)" class="py-3 px-5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold text-xs hover:bg-slate-200 transition">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- MEAL SLOT MODAL --}}
    @if($slotFormOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full border border-slate-200 dark:border-slate-800 shadow-2xl p-6 space-y-4">
            <h3 class="font-black text-slate-900 dark:text-white text-base pb-3 border-b border-slate-100 dark:border-slate-800">
                {{ $slotEditing ? $t('تعديل خانة الوجبة', 'Modifier Créneau', 'Edit Meal Slot') : $t('إضافة خانة وجبة جديدة', 'Nouveau Créneau', 'New Meal Slot') }}
            </h3>

            <form wire:submit.prevent="saveSlot()" class="space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">المطعم*</label>
                    <select wire:model="slot_restaurant_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                        <option value="">-- اختر المطعم --</option>
                        @foreach($allRestaurants as $rItem)
                        <option value="{{ $rItem->id }}">{{ $rItem->name_ar }}</option>
                        @endforeach
                    </select>
                    @error('slot_restaurant_id') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">تاريخ الوجبة*</label>
                        <input wire:model="slot_date" type="date" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">نوع الوجبة*</label>
                        <select wire:model="slot_meal_type" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                            <option value="BREAKFAST">فطور الصباح</option>
                            <option value="LUNCH">غداء</option>
                            <option value="DINNER">عشاء</option>
                            <option value="SNACK">وجبة خفيفة</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">بداية التوقيت*</label>
                        <input wire:model="slot_start" type="text" placeholder="12:00" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">نهاية التوقيت*</label>
                        <input wire:model="slot_end" type="text" placeholder="14:30" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">الحد الأقصى*</label>
                        <input wire:model="slot_capacity" type="number" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input wire:model="slot_is_open" type="checkbox" id="slot_open" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <label for="slot_open" class="text-xs font-bold text-slate-700 dark:text-slate-300">الخانة مفتوحة وجاهزة لاستقبال المسح</label>
                </div>

                <div class="flex items-center gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs transition shadow-md">
                        {{ $t('حفظ الخانة', 'Enregistrer Créneau', 'Save Slot') }}
                    </button>
                    <button type="button" wire:click="$set('slotFormOpen', false)" class="py-3 px-5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold text-xs hover:bg-slate-200 transition">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- ENTITLEMENT MODAL --}}
    @if($entitlementFormOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full border border-slate-200 dark:border-slate-800 shadow-2xl p-6 space-y-4">
            <h3 class="font-black text-slate-900 dark:text-white text-base pb-3 border-b border-slate-100 dark:border-slate-800">
                {{ $t('منح استحقاق وجبة جديد', 'Nouveau Droit Repas', 'New Meal Entitlement') }}
            </h3>

            <form wire:submit.prevent="saveEntitlement()" class="space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">خانة الوجبة*</label>
                    <select wire:model="ent_meal_slot_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                        @foreach($openSlotsToday as $openSlotItem)
                        <option value="{{ $openSlotItem->id }}">{{ $openSlotItem->restaurant?->name_ar }} — {{ $openSlotItem->meal_type }} ({{ $openSlotItem->date?->format('Y-m-d') }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">نوع التخصيص*</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer {{ $ent_assign_type === 'delegation' ? 'border-emerald-500 bg-emerald-50 text-emerald-900' : 'border-slate-200' }}">
                            <input type="radio" wire:model.live="ent_assign_type" value="delegation" class="text-emerald-600">
                            <span class="text-xs font-black">وفد كامل</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer {{ $ent_assign_type === 'user' ? 'border-emerald-500 bg-emerald-50 text-emerald-900' : 'border-slate-200' }}">
                            <input type="radio" wire:model.live="ent_assign_type" value="user" class="text-emerald-600">
                            <span class="text-xs font-black">مشارك فردي</span>
                        </label>
                    </div>
                </div>

                @if($ent_assign_type === 'delegation')
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">اختر الدولة / الوفد*</label>
                    <select wire:model="ent_country_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                        <option value="">-- اختر الوفد --</option>
                        @foreach($allCountries as $c)
                        <option value="{{ $c->id }}">{{ $c->name_ar }}</option>
                        @endforeach
                    </select>
                    @error('ent_country_id') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                </div>
                @else
                <div>
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">اختر المشارك*</label>
                    <select wire:model="ent_user_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                        <option value="">-- اختر المشارك --</option>
                        @foreach($allUsers as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                    @error('ent_user_id') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                </div>
                @endif

                <div class="flex items-center gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-md">
                        {{ $t('منح الاستحقاق', 'Accorder Droit', 'Grant Entitlement') }}
                    </button>
                    <button type="button" wire:click="$set('entitlementFormOpen', false)" class="py-3 px-5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold text-xs hover:bg-slate-200 transition">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- DELETE CONFIRMATION MODAL --}}
    @if($deleteOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-sm w-full border border-slate-200 dark:border-slate-800 shadow-2xl p-6 text-center space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="font-black text-slate-900 dark:text-white text-base">{{ $t('تأكيد عملية الحذف', 'Confirmer la suppression', 'Confirm Delete') }}</h3>
            <p class="text-xs text-slate-500 font-bold">{{ $t('هل أنت تأكد من رغبتك في حذف هذا العنصر؟ لا يمكن التراجع عن هذا الإجراء.', 'Voulez-vous vraiment supprimer cet élément ?', 'Are you sure you want to delete this item?') }}</p>
            <div class="flex items-center gap-3 pt-2">
                <button wire:click="executeDelete()" class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md transition">
                    {{ $t('حذف نهائي', 'Supprimer', 'Delete') }}
                </button>
                <button wire:click="$set('deleteOpen', false)" class="py-2.5 px-4 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold text-xs hover:bg-slate-200 transition">
                    {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                </button>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- HTML5 QR Code Scanner Library & Alpine JS Controller --}}
<script src="/js/html5-qrcode.min.js"></script>
<script>
if (typeof Html5Qrcode === 'undefined') {
    let script = document.createElement('script');
    script.src = 'https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js';
    document.head.appendChild(script);
}

function restaurantScanner() {
    return {
        html5QrcodeScanner: null,
        cameraActive: false,

        initScanner() {
            Livewire.on('scan-complete', (data) => {
                this.playBeep(data.status);
            });
        },

        async toggleCamera() {
            if (this.cameraActive) {
                this.stopCamera();
            } else {
                this.startCamera();
            }
        },

        async startCamera() {
            try {
                if (!this.html5QrcodeScanner) {
                    this.html5QrcodeScanner = new Html5Qrcode("meal-qr-reader");
                }
                const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                await this.html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText) => {
                        this.onQrCodeSuccess(decodedText);
                    },
                    () => {}
                );
                this.cameraActive = true;
            } catch (err) {
                console.error("Camera access failed:", err);
                alert("تعذر الوصول إلى الكاميرا. يرجى التأكد من منح إذن الكاميرا لموقعك.");
                this.cameraActive = false;
            }
        },

        async stopCamera() {
            if (this.html5QrcodeScanner && this.cameraActive) {
                try {
                    await this.html5QrcodeScanner.stop();
                } catch(e){}
                this.cameraActive = false;
            }
        },

        onQrCodeSuccess(code) {
            if (!code || !code.trim()) return;
            $wire.scanMealBadge(code.trim());
        },

        playBeep(status) {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);

                if (status === 'AUTHORIZED') {
                    osc.frequency.setValueAtTime(880, ctx.currentTime);
                    osc.frequency.setValueAtTime(1320, ctx.currentTime + 0.1);
                    gain.gain.setValueAtTime(0.3, ctx.currentTime);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.25);
                } else if (status === 'DUPLICATE') {
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(440, ctx.currentTime);
                    osc.frequency.setValueAtTime(330, ctx.currentTime + 0.15);
                    gain.gain.setValueAtTime(0.3, ctx.currentTime);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.35);
                } else {
                    osc.type = 'square';
                    osc.frequency.setValueAtTime(220, ctx.currentTime);
                    gain.gain.setValueAtTime(0.4, ctx.currentTime);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.4);
                }
            } catch(e) {}
        }
    }
}
</script>
