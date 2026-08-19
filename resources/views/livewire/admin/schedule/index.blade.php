<div class="space-y-6 pb-12">

    {{-- HEADER --}}
    <x-dashboard.page-header
        title="محرك الجدولة الميداني والتنظيم الشامل (WSAP Master Schedule Engine)"
        subtitle="لوحة الإدارة الشاملة للاجتماعات التقنية، المسابقات، الوجبات، النقل، السكن والفعاليات."
    >
        <button wire:click="$set('showCreateModal', true)" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-lg flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>إضافة حدث مجدول جديد</span>
        </button>
    </x-dashboard.page-header>

    {{-- FLASH MESSAGE --}}
    @if($flashMessage ?? null)
    <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-xs font-bold shadow-sm">
        ✓ {{ $flashMessage }}
    </div>
    @endif

    {{-- VIEW MODE TABS --}}
    <div class="flex flex-wrap items-center justify-between gap-4 bg-white dark:bg-slate-800 p-4 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-2">
            <button wire:click="$set('viewMode', 'operations')" class="px-4 py-2 rounded-xl text-xs font-black transition {{ ($viewMode ?? 'operations') === 'operations' ? 'bg-[#06205C] dark:bg-blue-600 text-white shadow-sm' : 'bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100' }}">
                🗺️ العمليات المباشرة (Operations)
            </button>
            <button wire:click="$set('viewMode', 'agenda')" class="px-4 py-2 rounded-xl text-xs font-black transition {{ ($viewMode ?? 'operations') === 'agenda' ? 'bg-[#06205C] dark:bg-blue-600 text-white shadow-sm' : 'bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100' }}">
                📋 جدول الأعمال (Agenda)
            </button>
            <button wire:click="$set('viewMode', 'calendar')" class="px-4 py-2 rounded-xl text-xs font-black transition {{ ($viewMode ?? 'operations') === 'calendar' ? 'bg-[#06205C] dark:bg-blue-600 text-white shadow-sm' : 'bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100' }}">
                📅 التقويم (Calendar)
            </button>
            <button wire:click="$set('viewMode', 'timeline')" class="px-4 py-2 rounded-xl text-xs font-black transition {{ ($viewMode ?? 'operations') === 'timeline' ? 'bg-[#06205C] dark:bg-blue-600 text-white shadow-sm' : 'bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100' }}">
                📊 المخطط الزمني (Timeline)
            </button>
        </div>

        <div class="flex items-center gap-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث بالحدث..." class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50">
            
            <select wire:model.live="filterType" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-white">
                <option value="">جميع أنواع الأحداث</option>
                <option value="TECHNICAL_MEETING">🏛️ اجتماع تقني</option>
                <option value="COMPETITION_ROUND">🏆 جولة مسابقة</option>
                <option value="MEAL_SLOT">🍽️ وجبة مطعم</option>
                <option value="TRANSPORT">🚌 رحلة نقل</option>
                <option value="ACCOMMODATION">🏠 سكن وإقامة</option>
                <option value="CEREMONY">🎤 مراسم افتتاح/اختتام</option>
            </select>
        </div>
    </div>

    {{-- KPI METRICS --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">إجمالي الأحداث المجدولة</div>
                <div class="text-xl font-black text-slate-900">{{ number_format($totalEvents) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">أحداث اليوم</div>
                <div class="text-xl font-black text-slate-900">{{ number_format($todayEvents) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">أحداث جارية الآن</div>
                <div class="text-xl font-black text-emerald-600">{{ number_format($activeEvents) }}</div>
            </div>
        </div>
    </div>

    {{-- EVENTS TABLE & AGENDA LIST --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-5 py-4 text-start">الحدث والنوع</th>
                        <th class="px-5 py-4 text-start">الموقع والمنطقة</th>
                        <th class="px-5 py-4 text-start">التخصص / الوفد</th>
                        <th class="px-5 py-4 text-start">التوقيت والبداية</th>
                        <th class="px-5 py-4 text-start">الحالة والدورة الحياتية</th>
                        <th class="px-5 py-4 text-end">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold">
                    @forelse($events as $e)
                        @php
                            $badgeType = match($e->event_type) {
                                'TECHNICAL_MEETING' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                'COMPETITION_ROUND' => 'bg-purple-100 text-purple-800 border-purple-300',
                                'MEAL_SLOT'         => 'bg-amber-100 text-amber-800 border-amber-300',
                                'TRANSPORT'         => 'bg-blue-100 text-blue-800 border-blue-300',
                                'CEREMONY'          => 'bg-rose-100 text-rose-800 border-rose-300',
                                default             => 'bg-slate-100 text-slate-800 border-slate-300',
                            };
                            $statusColor = match($e->status) {
                                'OPEN', 'IN_PROGRESS' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'COMPLETED'          => 'bg-blue-100 text-blue-800 border-blue-300',
                                'CANCELLED'          => 'bg-rose-100 text-rose-800 border-rose-300',
                                'POSTPONED'          => 'bg-amber-100 text-amber-800 border-amber-300',
                                default              => 'bg-slate-100 text-slate-700 border-slate-300',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4 space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border font-mono {{ $badgeType }}">
                                        {{ $e->event_type }}
                                    </span>
                                    <span class="font-black text-[#06205C] text-xs">{{ $e->title_ar }}</span>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <span class="font-bold text-slate-800 block">{{ $e->location_name ?: '—' }}</span>
                                @if($e->zone)
                                <span class="text-[10px] font-mono text-brand-600 font-bold block">📍 {{ $e->zone->code }} — {{ $e->zone->name_ar }}</span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="space-y-0.5 text-[11px]">
                                    @if($e->skill)
                                    <span class="font-bold text-indigo-700 block">🏆 {{ $e->skill->name_ar }}</span>
                                    @endif
                                    @if($e->country)
                                    <span class="font-bold text-emerald-700 block">🌍 {{ $e->country->name_ar }}</span>
                                    @endif
                                    @if(!$e->skill && !$e->country)
                                    <span class="text-slate-400 font-bold">—</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-5 py-4 font-mono text-[11px]">
                                <span class="font-black text-slate-900 block">{{ $e->start_at?->format('Y-m-d H:i') }}</span>
                                @if($e->end_at)
                                <span class="text-slate-400 text-[10px] block">إلى {{ $e->end_at->format('H:i') }}</span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border {{ $statusColor }}">
                                    {{ $e->status }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-end">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($e->status === 'SCHEDULED')
                                    <button wire:click="transitionStatus({{ $e->id }}, 'OPEN')" class="px-2.5 py-1 rounded-xl bg-emerald-600 text-white font-black text-[10px]">
                                        فتح الحدث 🚀
                                    </button>
                                    @endif

                                    @if(in_array($e->status, ['SCHEDULED', 'OPEN']))
                                    <button wire:click="transitionStatus({{ $e->id }}, 'CANCELLED')" wire:confirm="هل أنت تأكد من إلغاء هذا الحدث وإرسال تنبيه إلغاء للمستهدفين؟" class="px-2.5 py-1 rounded-xl bg-rose-100 text-rose-700 font-black text-[10px]">
                                        إلغاء 🚨
                                    </button>
                                    @endif

                                    <button wire:click="deleteEvent({{ $e->id }})" wire:confirm="حذف الحدث من الجدول؟" class="p-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400 font-bold">
                                لا توجد أحداث مجدولة حالياً. اضغط على "إضافة حدث مجدول جديد".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($events->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">{{ $events->links() }}</div>
        @endif
    </div>

    {{-- CREATE EVENT MODAL --}}
    @if($showCreateModal ?? false)
    <div class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 space-y-4 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-black text-[#06205C]">إضافة حدث مجدول جديد للمنصة</h3>
                <button wire:click="$set('showCreateModal', false)" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">نوع الحدث *</label>
                    <select wire:model="event_type" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold bg-slate-50">
                        <option value="TECHNICAL_MEETING">🏛️ اجتماع تقني (Technical Meeting)</option>
                        <option value="COMPETITION_ROUND">🏆 جولة مسابقة (Competition Round)</option>
                        <option value="MEAL_SLOT">🍽️ وجبة مطعم (Meal Slot)</option>
                        <option value="TRANSPORT">🚌 رحلة نقل (Transport Transfer)</option>
                        <option value="ACCOMMODATION">🏠 سكن وإقامة (Accommodation)</option>
                        <option value="CEREMONY">🎤 مراسم افتتاح/اختتام (Ceremony)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">عنوان الحدث بالعربية *</label>
                    <input type="text" wire:model="title_ar" required placeholder="مثال: اجتماع تقني لمهنة ميكانيك السيارات" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">تاريخ ووقت البداية *</label>
                        <input type="datetime-local" wire:model="start_at" required class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold bg-slate-50">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">تاريخ ووقت النهاية</label>
                        <input type="datetime-local" wire:model="end_at" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold bg-slate-50">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">اسم القاعة / القواطع / المكان</label>
                    <input type="text" wire:model="location_name" placeholder="مثال: قاعة الاجتماعات الرئيسية B" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">المنطقة المخصصة (Zone)</label>
                        <select wire:model="zone_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold bg-slate-50">
                            <option value="">بدون منطقة</option>
                            @foreach($zones as $z)
                            <option value="{{ $z->id }}">{{ $z->code }} — {{ $z->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">التخصص المعني (Skill)</label>
                        <select wire:model="skill_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold bg-slate-50">
                            <option value="">جميع التخصصات</option>
                            @foreach($skills as $sk)
                            <option value="{{ $sk->id }}">{{ $sk->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button wire:click="$set('showCreateModal', false)" type="button" class="px-4 py-2 rounded-xl bg-slate-100 font-bold text-xs">إلغاء</button>
                <button wire:click="createEvent" type="button" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-black text-xs shadow-md">حفظ وإضافة للجدول 🚀</button>
            </div>
        </div>
    </div>
    @endif

</div>
