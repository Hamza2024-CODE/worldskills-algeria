<div class="space-y-6 pb-8">

    <!-- Header -->
    <x-dashboard.page-header
        title="مركز إدارة الأحداث والفاعليات المنظّمة"
        subtitle="التحكم بالحدث النشط، العد التنازلي، التواريخ، والربط الفوري بالبوابة الوطنية"
    >
        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>إضافة حدث/فاعلية جديدة</span>
        </button>
    </x-dashboard.page-header>

    <!-- Search & Filters -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث بعنوان الفاعلية، المقر، أو التفاصيل..." class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 flex-1">
        <select wire:model.live="filterStatus" class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 font-bold focus:outline-none">
            <option value="">جميع الأحداث</option>
            <option value="1">الحدث الرئيسي النشط</option>
            <option value="0">أحداث غير مفعلة</option>
        </select>
    </div>

    <!-- Events Cards Grid -->
    <div class="space-y-4">
        @forelse($events as $event)
            <div class="p-6 rounded-3xl border {{ $event->is_active ? 'border-blue-500 bg-blue-50/40 dark:bg-blue-900/10' : 'border-slate-200 bg-white dark:bg-slate-800' }} shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4 transition">
                <div class="space-y-1.5 flex-1">
                    <div class="flex items-center gap-2">
                        @if($event->is_active)
                            <span class="px-3 py-1 rounded-full bg-blue-600 text-white font-black text-[10px] shadow-xs flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>الحدث النشط الرئيسي حالياً</span>
                            </span>
                        @endif
                        <span class="text-xs font-mono font-bold text-slate-500">
                            {{ $event->start_at ? $event->start_at->format('Y-m-d H:i') : '2026' }}
                        </span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $event->title_ar }}</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">{{ $event->summary_ar ?: 'بدون ملخص' }}</p>
                    @if($event->venue)
                        <div class="text-xs font-bold text-blue-600 flex items-center gap-1 pt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>المقر: {{ $event->venue }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    @if(!$event->is_active)
                        <button wire:click="toggleActive({{ $event->id }})" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>تفعيل كحدث رئيسي</span>
                        </button>
                    @else
                        <span class="px-4 py-2 rounded-xl bg-emerald-100 text-emerald-800 font-bold text-xs border border-emerald-200 flex items-center gap-1">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>مفعل بالصفحة الرئيسية</span>
                        </span>
                    @endif

                    <button wire:click="openDrawer({{ $event->id }})" class="p-2 rounded-xl text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition" title="عرض التفاصيل">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                    <button wire:click="openEdit({{ $event->id }})" class="p-2 rounded-xl text-slate-500 hover:text-amber-600 hover:bg-slate-100 transition" title="تعديل">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button wire:click="confirmDelete({{ $event->id }})" class="p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-slate-100 transition" title="حذف">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-slate-400 font-bold bg-white rounded-3xl border border-slate-200">
                لا توجد أحداث مسجلة حالياً.
            </div>
        @endforelse
    </div>

    <!-- CREATE / EDIT MODAL -->
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-lg w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl overflow-y-auto max-h-[90vh]">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $isEditing ? 'تعديل الفاعلية والحدث' : 'إضافة حدث جديد' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-4 text-xs font-semibold">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">عنوان الفاعلية (بالعربية) *</label>
                        <input wire:model="title_ar" type="text" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">عنوان الفاعلية (بالفرنسية) *</label>
                        <input wire:model="title_fr" type="text" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">الملخص التوضيحي</label>
                        <textarea wire:model="summary_ar" rows="2" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100"></textarea>
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">مقر الانعقاد والمركز</label>
                        <input wire:model="venue" type="text" placeholder="الجزائر العاصمة - قصر المعارض" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">تاريخ البدء</label>
                            <input wire:model="start_at" type="datetime-local" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">تاريخ الانتهاء</label>
                            <input wire:model="end_at" type="datetime-local" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="save" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">حفظ البيانات</button>
                </div>
            </div>
        </div>
    @endif

    <!-- DETAILS DRAWER -->
    @if($drawerOpen && $selectedEvent)
        <div class="fixed inset-0 z-50 overflow-hidden bg-slate-900/60 backdrop-blur-xs flex justify-end transition-opacity">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 h-full shadow-2xl flex flex-col justify-between overflow-y-auto p-6 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $selectedEvent->title_ar }}</h2>
                        <span class="text-xs font-mono font-bold text-blue-600">{{ $selectedEvent->start_at ? $selectedEvent->start_at->format('Y-m-d H:i') : '2026' }}</span>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>

                <div class="space-y-4 text-xs font-semibold flex-1">
                    <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-2xl space-y-2 border border-slate-100 dark:border-slate-600">
                        <div class="flex justify-between"><span class="text-slate-400">الاسم بالفرنسية:</span><span class="font-bold text-slate-900 dark:text-slate-100 font-mono">{{ $selectedEvent->title_fr ?? '—' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">المقر:</span><span class="font-bold text-blue-600">{{ $selectedEvent->venue ?? 'الجزائر العاصمة' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">الحالة بالبوابة:</span><span class="font-black {{ $selectedEvent->is_active ? 'text-emerald-600' : 'text-slate-400' }}">{{ $selectedEvent->is_active ? 'مفعل كرئيسي' : 'غير مفعل' }}</span></div>
                    </div>
                    @if($selectedEvent->summary_ar)
                        <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-2xl space-y-1">
                            <span class="text-slate-400 font-bold block">الملخص بالعربية:</span>
                            <p class="text-slate-700 dark:text-slate-200 leading-relaxed">{{ $selectedEvent->summary_ar }}</p>
                        </div>
                    @endif
                </div>

                <div class="flex gap-2 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="openEdit({{ $selectedEvent->id }})" class="flex-1 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs transition">تعديل الحدث</button>
                    <button wire:click="confirmDelete({{ $selectedEvent->id }})" class="flex-1 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs transition">حذف الحدث</button>
                </div>
            </div>
        </div>
    @endif

    <!-- DELETE CONFIRM MODAL -->
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-sm w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl text-center">
                <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-base font-black text-slate-900 dark:text-slate-100">تأكيد حذف الحدث</h3>
                <p class="text-xs text-slate-500 font-medium">هل أنت متأكد من رغبتك في حذف هذا الحدث من النظام؟</p>
                <div class="flex justify-center gap-2 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="deleteEvent" class="px-5 py-2 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif

</div>
