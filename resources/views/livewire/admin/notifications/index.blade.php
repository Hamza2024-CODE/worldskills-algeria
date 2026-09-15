<div class="space-y-6 pb-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-[#06205C] text-white flex items-center justify-center shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-[#06205C]">مركز التنبيهات والتواصل المركزي (Communication Center)</h1>
                <p class="text-xs text-slate-500 font-medium">
                    إدارة التنبيهات الموجهة وتتبع نتائج التسليم والتفاعل لجميع الوفود، المشاركين، الحكام، الوجبات والسكن.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.notifications.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black transition shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>إنشاء تنبيه جديد (Audience Builder)</span>
            </a>
        </div>
    </div>

    {{-- FLASH MESSAGE --}}
    @if($flashMessage || session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold shadow-sm">
        <x-ws.icon name="check-circle" class="w-4 h-4 inline-block me-1 text-emerald-600" /> {{ $flashMessage ?: session("success") }}
    </div>
    @endif

    {{-- KPI ANALYTICS DASHBOARD --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">إجمالي التنبيهات</div>
                <div class="text-xl font-black text-slate-900">{{ number_format($totalCount) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">تم إرسالها (Sent)</div>
                <div class="text-xl font-black text-slate-900">{{ number_format($sentCount) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">مجدولة (Scheduled)</div>
                <div class="text-xl font-black text-slate-900">{{ number_format($scheduledCount) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">تنبيهات عاجلة (Urgent)</div>
                <div class="text-xl font-black text-slate-900">{{ number_format($urgentCount) }}</div>
            </div>
        </div>
    </div>

    {{-- SEARCH & FILTERS --}}
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="w-full sm:w-80 relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث بنص التنبيه أو العنوان..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-[#06205C] focus:ring-2 focus:ring-brand-500 bg-slate-50">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex items-center gap-3">
            <select wire:model.live="filterType" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-black text-[#06205C] bg-white">
                <option value="">جميع أنواع التنبيهات</option>
                <option value="GENERAL">GENERAL (عام)</option>
                <option value="TECHNICAL_MEETING">TECHNICAL_MEETING (اجتماع تقني)</option>
                <option value="MEAL">MEAL (وجبة/مطعم)</option>
                <option value="ACCOMMODATION">ACCOMMODATION (سكن)</option>
                <option value="COMPETITION">COMPETITION (مسابقة)</option>
                <option value="SCHEDULE">SCHEDULE (برنامج)</option>
                <option value="URGENT">URGENT (عاجل)</option>
            </select>

            <select wire:model.live="filterStatus" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-black text-[#06205C] bg-white">
                <option value="">جميع الحالات</option>
                <option value="DRAFT">DRAFT / مسودة</option>
                <option value="SCHEDULED">SCHEDULED / مجدول</option>
                <option value="SENT">SENT / تم الإرسال</option>
                <option value="CANCELLED">CANCELLED / ملغى</option>
            </select>
        </div>
    </div>

    {{-- NOTIFICATIONS TABLE --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-5 py-4 text-start">التنبيه والنوع</th>
                        <th class="px-5 py-4 text-start">الأولوية والـ Action</th>
                        <th class="px-5 py-4 text-start">المستهدفون (Targets)</th>
                        <th class="px-5 py-4 text-start">نتائج التسليم (Delivery)</th>
                        <th class="px-5 py-4 text-start">الحالة والوقت</th>
                        <th class="px-5 py-4 text-end">الإجراءات (Actions)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold">
                    @forelse($notifications as $n)
                        @php
                            $stats = $analyticsMap[$n->id] ?? ['total' => 0, 'delivered' => 0, 'read' => 0, 'clicked' => 0, 'read_pct' => 0];
                            $typeBadge = match($n->type) {
                                'MEAL'              => 'bg-amber-100 text-amber-800 border-amber-300',
                                'TECHNICAL_MEETING' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                'ACCOMMODATION'      => 'bg-teal-100 text-teal-800 border-teal-300',
                                'COMPETITION'        => 'bg-purple-100 text-purple-800 border-purple-300',
                                'URGENT'             => 'bg-rose-100 text-rose-800 border-rose-300',
                                default              => 'bg-slate-100 text-slate-800 border-slate-300',
                            };
                            $prioColor = match($n->priority) {
                                'URGENT' => 'bg-rose-500 text-white',
                                'HIGH'   => 'bg-amber-500 text-white',
                                default  => 'bg-slate-200 text-slate-700',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4 space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border font-mono {{ $typeBadge }}">
                                        {{ $n->type }}
                                    </span>
                                    <span class="font-black text-[#06205C] text-xs">
                                        {{ $n->title_ar }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 line-clamp-1">
                                    {{ $n->body_ar }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <div class="space-y-1">
                                    <span class="px-2 py-0.5 rounded-md text-[9px] font-black {{ $prioColor }}">
                                        {{ $n->priority }}
                                    </span>
                                    @if($n->action_type)
                                    <span class="block text-[10px] font-mono text-brand-600 font-bold">
                                        <x-ws.icon name="link" class="w-3.5 h-3.5 inline-block me-1 text-slate-400" /> {{ $n->action_type }}
                                    </span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($n->targets as $t)
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-bold">
                                        {{ $t->target_type }}: {{ $t->target_id }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                @if($n->status === 'SENT')
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-[11px]">
                                        <span class="font-black text-slate-800">{{ $stats['read'] }} / {{ $stats['total'] }} مقروء</span>
                                        <span class="text-emerald-600 font-extrabold">({{ $stats['read_pct'] }}%)</span>
                                    </div>
                                    <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full" :style="'width: ' + {{ (float)$stats['read_pct'] }} + '%'"></div>
                                    </div>
                                    <span class="text-[9px] text-slate-400 font-mono block">نقرات: {{ $stats['clicked'] }}</span>
                                </div>
                                @else
                                <span class="text-[11px] text-slate-400 font-bold">—</span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold
                                    {{ $n->status === 'SENT' ? 'bg-emerald-100 text-emerald-700' : ($n->status === 'SCHEDULED' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                    {{ $n->status }}
                                </span>
                                <span class="block text-[10px] text-slate-400 mt-1 font-mono">
                                    {{ $n->created_at->format('Y-m-d H:i') }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    @if($n->status === 'DRAFT' || $n->status === 'SCHEDULED')
                                    <button wire:click="dispatchNow({{ $n->id }})" class="px-3 py-1 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[11px] transition shadow-xs">
                                        <x-ws.icon name="arrow-up-tray" class="w-4 h-4 inline-block me-1" /> إرسال الآن
                                    </button>
                                    @endif

                                    @if($n->status === 'SCHEDULED')
                                    <button wire:click="cancelNotification({{ $n->id }})" class="px-3 py-1 rounded-xl bg-amber-100 text-amber-700 hover:bg-amber-200 font-bold text-[11px] transition">
                                        إلغاء
                                    </button>
                                    @endif

                                    <button wire:click="duplicateNotification({{ $n->id }})" title="تكرار كمسودة" class="p-1.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>

                                    <button wire:click="deleteNotification({{ $n->id }})" wire:confirm="هل أنت تأكد من حذف هذا التنبيه؟" class="p-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400 font-bold">
                                لا توجد تنبيهات مسجلة حالياً. انقر على "إنشاء تنبيه جديد" لبدء الإرسال.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($notifications->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $notifications->links() }}</div>
        @endif
    </div>

</div>
