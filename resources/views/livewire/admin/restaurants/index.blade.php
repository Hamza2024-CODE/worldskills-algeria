@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-6 p-4 sm:p-6" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Flash --}}
    @if($flashMessage)
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         class="flex items-center gap-3 p-4 rounded-2xl {{ $flashType === 'success' ? 'bg-emerald-50 border border-emerald-200 text-emerald-900' : 'bg-amber-50 border border-amber-200 text-amber-900' }} text-sm font-bold shadow-sm">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ $flashMessage }}
    </div>
    @endif

    {{-- Header --}}
    <x-dashboard.page-header
        :title="$t('مركز إدارة المطاعم والوجبات والمطابخ', 'Centre de Gestion de Restauration', 'Catering & Meals Management Center')"
        subtitle="WSAP — Catering & Meal Access Control System"
    >
        <a href="{{ route('admin.meal.scanner') }}" class="flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-black text-xs transition backdrop-blur-md shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16.97 16.97l2.83 2.83M5 5l14 14"/></svg>
            <span>{{ $t('ماسح شارة المطعم', 'Scanner Repas', 'Meal Badge Scanner') }}</span>
        </a>
        <button wire:click="openRestaurantForm()" class="flex items-center gap-1.5 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $t('إضافة مطعم جديد', 'Ajouter un Restaurant', 'Add Restaurant') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- KPI Dashboard --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm text-center">
            <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalAuthorized }}</div>
            <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $t('مسموح اليوم', 'Autorisés Aujourd\'hui', 'Authorized Today') }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm text-center">
            <div class="text-2xl font-black text-slate-900">{{ $totalDenied }}</div>
            <div class="text-xs font-bold text-rose-600 mt-1">مرفوض اليوم</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm text-center">
            <div class="text-2xl font-black text-slate-900">{{ $totalDuplicate }}</div>
            <div class="text-xs font-bold text-amber-600 mt-1">مكرر اليوم</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm text-center">
            <div class="text-2xl font-black text-slate-900">{{ $totalCapacity }}</div>
            <div class="text-xs font-bold text-blue-600 mt-1">الطاقة الكلية</div>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="flex items-center gap-1 bg-slate-100 p-1.5 rounded-2xl overflow-x-auto">
        @foreach([
            ['restaurants', 'المطاعم'],
            ['slots',       'الوجبات'],
            ['entitlements','الاستحقاقات'],
            ['scans',       'سجل المسح'],
        ] as [$tab, $label])
        <button wire:click="$set('activeTab', '{{ $tab }}')"
            class="px-4 py-2 rounded-xl text-xs font-black whitespace-nowrap transition
                   {{ $activeTab === $tab ? 'bg-white text-[#06205C] shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════════════════
         TAB: RESTAURANTS
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'restaurants')
    <div class="space-y-3">
        <div class="flex items-center gap-2">
            <input wire:model.live.debounce.300ms="search" type="search" placeholder="بحث في المطاعم..."
                   class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white">
            <select wire:model.live="filterStatus" class="px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white">
                <option value="">كل الحالات</option>
                <option value="active">مفتوح</option>
                <option value="inactive">مغلق</option>
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($restaurants as $r)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition overflow-hidden">
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-black text-slate-900 text-sm">{{ $r->name_ar }}</h3>
                            @if($r->name_fr) <p class="text-[10px] text-slate-400 font-medium">{{ $r->name_fr }}</p> @endif
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $r->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $r->is_active ? 'مفتوح' : 'مغلق' }}
                        </span>
                    </div>

                    @if($r->location)
                    <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $r->location }}
                    </div>
                    @endif

                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-slate-600">الطاقة: <span class="text-slate-900">{{ number_format($r->capacity) }}</span></span>
                        <span class="text-blue-700">{{ $r->meal_slots_count }} خانة وجبة</span>
                    </div>
                </div>

                {{-- Today's Slots mini-preview --}}
                @php $todayR = $r->todaySlots; @endphp
                @if($todayR->count())
                <div class="border-t border-slate-100 px-4 py-2 flex gap-2 flex-wrap">
                    @foreach($todayR as $ts)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $ts->is_open ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $ts->start_time }} — {{ $ts->end_time }}
                    </span>
                    @endforeach
                </div>
                @endif

                <div class="border-t border-slate-100 p-3 flex items-center gap-2">
                    <button wire:click="openRestaurantForm({{ $r->id }})"
                        class="flex-1 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-black text-[10px] transition">
                        تعديل
                    </button>
                    <button wire:click="openSlotForm({{ $r->id }})"
                        class="flex-1 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-black text-[10px] transition">
                        + وجبة
                    </button>
                    <button wire:click="toggleRestaurantStatus({{ $r->id }})"
                        class="flex-1 py-1.5 rounded-lg {{ $r->is_active ? 'bg-rose-50 hover:bg-rose-100 text-rose-700' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700' }} font-black text-[10px] transition">
                        {{ $r->is_active ? 'إغلاق' : 'فتح' }}
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-16 text-slate-400 text-sm font-bold">
                لا توجد مطاعم. ابدأ بإضافة أول مطعم.
            </div>
            @endforelse
        </div>

        <div class="mt-4">{{ $restaurants->links() }}</div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         TAB: MEAL SLOTS
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'slots')
    <div class="space-y-3">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
            <input wire:model.live="filterDate" type="date" class="px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white">
            <select wire:model.live="filterMeal" class="px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white">
                <option value="">كل الوجبات</option>
                <option value="BREAKFAST">الإفطار</option>
                <option value="LUNCH">الغداء</option>
                <option value="DINNER">العشاء</option>
                <option value="SNACK">الوجبة الخفيفة</option>
            </select>
            <button wire:click="openSlotForm()" class="px-4 py-2 rounded-xl bg-[#06205C] text-white font-black text-xs">
                + إضافة خانة وجبة
            </button>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
            <table class="w-full text-xs font-bold">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wide text-[10px]">
                    <tr>
                        <th class="px-4 py-3 text-right">المطعم</th>
                        <th class="px-4 py-3 text-right">التاريخ</th>
                        <th class="px-4 py-3 text-right">الوجبة</th>
                        <th class="px-4 py-3 text-right">الوقت</th>
                        <th class="px-4 py-3 text-right">الطاقة</th>
                        <th class="px-4 py-3 text-right">الدخول / المتبقي</th>
                        <th class="px-4 py-3 text-right">الحالة</th>
                        <th class="px-4 py-3 text-right">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($mealSlots as $slot)
                    @php
                        $auth = $slot->scans->where('status','AUTHORIZED')->count();
                        $pct  = $slot->max_capacity > 0 ? round(($auth/$slot->max_capacity)*100) : 0;
                        $barColor = $pct >= 95 ? 'bg-rose-500' : ($pct >= 75 ? 'bg-amber-500' : 'bg-emerald-500');
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-black text-slate-900">{{ $slot->restaurant?->name_ar }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $slot->date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">
                                {{ $slot->meal_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-600 font-mono">{{ $slot->start_time }} — {{ $slot->end_time }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ number_format($slot->max_capacity) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-slate-200 rounded-full overflow-hidden w-16">
                                    <div class="h-full {{ $barColor }} rounded-full" :style="'width: ' + {{ $pct }} + '%'"></div>
                                </div>
                                <span class="{{ $barColor === 'bg-rose-500' ? 'text-rose-700' : ($barColor === 'bg-amber-500' ? 'text-amber-700' : 'text-emerald-700') }}">
                                    {{ $auth }} / {{ max(0, $slot->max_capacity - $auth) }} متبقي
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $slot->is_open ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $slot->is_open ? 'مفتوحة' : 'مغلقة' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1.5">
                                <button wire:click="openSlotForm(null, {{ $slot->id }})" class="px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition text-[10px]">تعديل</button>
                                <button wire:click="toggleSlotStatus({{ $slot->id }})" class="px-2 py-1 rounded-lg {{ $slot->is_open ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }} transition text-[10px]">
                                    {{ $slot->is_open ? 'إغلاق' : 'فتح' }}
                                </button>
                                <button wire:click="openEntitlementForm({{ $slot->id }})" class="px-2 py-1 rounded-lg bg-blue-50 text-blue-700 transition text-[10px]">استحقاق</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-4 py-12 text-center text-slate-400 font-bold">لا توجد خانات وجبات لهذا اليوم.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $mealSlots->links() }}</div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         TAB: SCANS LOG
    ══════════════════════════════════════════════════════════ --}}
    @if($activeTab === 'scans')
    <div class="space-y-3">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
            <input wire:model.live="filterDate" type="date" class="px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white">
            <select wire:model.live="filterMeal" class="px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white">
                <option value="">كل الوجبات</option>
                <option value="BREAKFAST">الإفطار</option>
                <option value="LUNCH">الغداء</option>
                <option value="DINNER">العشاء</option>
                <option value="SNACK">الوجبة الخفيفة</option>
            </select>
            <select wire:model.live="filterStatus" class="px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white">
                <option value="">كل الحالات</option>
                <option value="AUTHORIZED">مسموح</option>
                <option value="DENIED">مرفوض</option>
                <option value="DUPLICATE">مكرر</option>
            </select>
            <button wire:click="exportScansCsv()" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                تصدير CSV
            </button>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
            <table class="w-full text-xs font-bold">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wide text-[10px]">
                    <tr>
                        <th class="px-4 py-3 text-right">الحالة</th>
                        <th class="px-4 py-3 text-right">الاسم</th>
                        <th class="px-4 py-3 text-right">الدولة</th>
                        <th class="px-4 py-3 text-right">الوجبة</th>
                        <th class="px-4 py-3 text-right">المطعم</th>
                        <th class="px-4 py-3 text-right">الوقت</th>
                        <th class="px-4 py-3 text-right">سبب الرفض</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($scansLog as $scan)
                    <tr class="hover:bg-slate-50 {{ $scan->status === 'AUTHORIZED' ? '' : ($scan->status === 'DUPLICATE' ? 'bg-amber-50/40' : 'bg-rose-50/40') }}">
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black
                                {{ $scan->status === 'AUTHORIZED' ? 'bg-emerald-100 text-emerald-700' : ($scan->status === 'DUPLICATE' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                {{ $scan->status === 'AUTHORIZED' ? 'مسموح' : ($scan->status === 'DUPLICATE' ? 'مكرر' : 'مرفوض') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-900 font-black">{{ $scan->participant_name_snapshot }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $scan->country_snapshot }}</td>
                        <td class="px-4 py-3">
                            {{ $scan->meal_type_snapshot }}
                        </td>
                        <td class="px-4 py-3 text-slate-700">{{ $scan->restaurant_snapshot }}</td>
                        <td class="px-4 py-3 font-mono text-slate-500">{{ $scan->scanned_at?->format('H:i:s') }}</td>
                        <td class="px-4 py-3 text-rose-600 text-[10px]">{{ $scan->denial_reason ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-12 text-center text-slate-400 font-bold">لا توجد سجلات مسح لهذا اليوم.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $scansLog->links() }}</div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         MODAL: Restaurant Form
    ══════════════════════════════════════════════════════════ --}}
    @if($restaurantFormOpen)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-black text-slate-900 text-lg">{{ $restaurantEditing ? 'تعديل المطعم' : 'إضافة مطعم جديد' }}</h2>
                <button wire:click="$set('restaurantFormOpen', false)" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-bold">
                <div class="sm:col-span-2">
                    <label class="block text-slate-700 mb-1">اسم المطعم (عربي) *</label>
                    <input wire:model="name_ar" type="text" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                    @error('name_ar') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">الاسم (فرنسي)</label>
                    <input wire:model="name_fr" type="text" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">الاسم (إنجليزي)</label>
                    <input wire:model="name_en" type="text" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">الموقع / الجناح</label>
                    <input wire:model="location" type="text" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">رقم الاتصال</label>
                    <input wire:model="contact_phone" type="text" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">الطاقة الاستيعابية *</label>
                    <input wire:model="capacity" type="number" min="1" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                    @error('capacity') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-center gap-2 pt-4">
                    <input wire:model="is_active" type="checkbox" id="is_active_r" class="w-4 h-4 rounded">
                    <label for="is_active_r" class="text-slate-700">مطعم نشط / مفتوح</label>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-slate-700 mb-1">ملاحظات</label>
                    <textarea wire:model="notes_r" rows="2" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 resize-none"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button wire:click="$set('restaurantFormOpen', false)" class="px-5 py-2 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs">إلغاء</button>
                <button wire:click="saveRestaurant()" class="px-5 py-2 rounded-xl bg-[#06205C] text-white font-black text-xs">
                    {{ $restaurantEditing ? 'حفظ التعديلات' : 'إضافة المطعم' }}
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL: Meal Slot Form --}}
    @if($slotFormOpen)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-black text-slate-900 text-lg">{{ $slotEditing ? 'تعديل خانة الوجبة' : 'إضافة خانة وجبة' }}</h2>
                <button wire:click="$set('slotFormOpen', false)" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-bold">
                <div class="sm:col-span-2">
                    <label class="block text-slate-700 mb-1">المطعم *</label>
                    <select wire:model="slot_restaurant_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        <option value="">اختر مطعماً</option>
                        @foreach($allRestaurants as $r) <option value="{{ $r->id }}">{{ $r->name_ar }}</option> @endforeach
                    </select>
                    @error('slot_restaurant_id') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">التاريخ *</label>
                    <input wire:model="slot_date" type="date" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">نوع الوجبة *</label>
                    <select wire:model="slot_meal_type" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        <option value="BREAKFAST">الإفطار</option>
                        <option value="LUNCH">الغداء</option>
                        <option value="DINNER">العشاء</option>
                        <option value="SNACK">الوجبة الخفيفة</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">وقت البداية *</label>
                    <input wire:model="slot_start" type="time" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">وقت الانتهاء *</label>
                    <input wire:model="slot_end" type="time" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">الطاقة الاستيعابية *</label>
                    <input wire:model="slot_capacity" type="number" min="1" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                </div>
                <div class="flex items-center gap-2 pt-4">
                    <input wire:model="slot_is_open" type="checkbox" id="slot_open" class="w-4 h-4 rounded">
                    <label for="slot_open" class="text-slate-700">الوجبة مفتوحة للمسح</label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button wire:click="$set('slotFormOpen', false)" class="px-5 py-2 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs">إلغاء</button>
                <button wire:click="saveSlot()" class="px-5 py-2 rounded-xl bg-[#06205C] text-white font-black text-xs">
                    {{ $slotEditing ? 'حفظ التعديلات' : 'إضافة الخانة' }}
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL: Entitlement Form --}}
    @if($entitlementFormOpen)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-black text-slate-900 text-lg">منح استحقاق الوجبة</h2>
                <button wire:click="$set('entitlementFormOpen', false)" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-3 text-xs font-bold">
                <div class="grid grid-cols-2 gap-2">
                    <button wire:click="$set('ent_assign_type', 'delegation')"
                        class="py-3 rounded-xl text-center {{ $ent_assign_type === 'delegation' ? 'bg-[#06205C] text-white' : 'bg-slate-100 text-slate-600' }} transition font-black text-xs">
                        وفد بأكمله
                    </button>
                    <button wire:click="$set('ent_assign_type', 'user')"
                        class="py-3 rounded-xl text-center {{ $ent_assign_type === 'user' ? 'bg-[#06205C] text-white' : 'bg-slate-100 text-slate-600' }} transition font-black text-xs">
                        شخص محدد
                    </button>
                </div>

                @if($ent_assign_type === 'delegation')
                <div>
                    <label class="block text-slate-700 mb-1">اختر الوفد / الدولة *</label>
                    <select wire:model="ent_country_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        <option value="">اختر الدولة</option>
                        @foreach($allCountries as $c) <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->code }})</option> @endforeach
                    </select>
                    @error('ent_country_id') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                </div>
                @else
                <div>
                    <label class="block text-slate-700 mb-1">اختر الشخص *</label>
                    <select wire:model="ent_user_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        <option value="">اختر المستخدم</option>
                        @foreach($allUsers as $u) <option value="{{ $u->id }}">{{ $u->name }} — {{ $u->email }}</option> @endforeach
                    </select>
                    @error('ent_user_id') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                </div>
                @endif
            </div>

            <p class="text-[10px] text-amber-700 bg-amber-50 rounded-xl p-3 font-medium">
                تنبيه: سيتم منح الاستحقاق لهذه الوجبة المحددة فقط. لمنح وجبات متعددة، كرر العملية لكل وجبة.
            </p>

            <div class="flex items-center justify-end gap-3">
                <button wire:click="$set('entitlementFormOpen', false)" class="px-5 py-2 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs">إلغاء</button>
                <button wire:click="saveEntitlement()" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-black text-xs">منح الاستحقاق</button>
            </div>
        </div>
    </div>
    @endif

</div>
