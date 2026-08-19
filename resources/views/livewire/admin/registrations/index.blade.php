@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-5 pb-8" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <x-dashboard.page-header
        :title="$t('إدارة طلبات التسجيل والترشيحات', 'Gestion des Inscriptions & Candidatures', 'Registrations & Applications Management')"
        :subtitle="$t('إجمالي الطلبات: ', 'Total Inscriptions: ', 'Total Applications: ') . $totalRegistrations . ' — ' . $t('مقبول: ', 'Approuvé: ', 'Approved: ') . $approvedCount . ' — ' . $t('قيد الدراسة: ', 'En Cours: ', 'Pending: ') . $pendingCount"
    >
        <div class="flex items-center gap-2">
            <span class="px-3.5 py-2 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-black backdrop-blur-md">{{ $t('مقبول: ', 'Approuvé: ', 'Approved: ') }}{{ $approvedCount }}</span>
            <span class="px-3.5 py-2 rounded-2xl bg-amber-500/20 border border-amber-400/30 text-amber-300 text-xs font-black backdrop-blur-md">{{ $t('قيد الدراسة: ', 'En Cours: ', 'Pending: ') }}{{ $pendingCount }}</span>
            <span class="px-3.5 py-2 rounded-2xl bg-rose-500/20 border border-rose-400/30 text-rose-300 text-xs font-black backdrop-blur-md">{{ $t('مرفوض: ', 'Refusé: ', 'Rejected: ') }}{{ $rejectedCount }}</span>
        </div>
    </x-dashboard.page-header>

    {{-- FILTERS --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ $t('بحث برمز التسجيل أو اسم المترشح...', 'Rechercher par code ou nom...', 'Search by code or candidate name...') }}"
                class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select wire:model.live="filterSkill"
            class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل التخصصات', 'Tous les Métiers', 'All Skills') }}</option>
            @foreach($skills as $skill)
                <option value="{{ $skill->id }}">{{ $skill->getLocalized('name') }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterStatus"
            class="px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل الحالات', 'Tous les Statuts', 'All Statuses') }}</option>
            <option value="SUBMITTED">{{ $t('قيد الدراسة (SUBMITTED)', 'En Attente (SUBMITTED)', 'Pending (SUBMITTED)') }}</option>
            <option value="APPROVED">{{ $t('مقبول (APPROVED)', 'Approuvé (APPROVED)', 'Approved (APPROVED)') }}</option>
            <option value="REJECTED">{{ $t('مرفوض (REJECTED)', 'Refusé (REJECTED)', 'Rejected (REJECTED)') }}</option>
        </select>
    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-5 py-3.5 text-start">رمز الطلب</th>
                        <th class="px-5 py-3.5 text-start">المترشح / المتنافس</th>
                        <th class="px-5 py-3.5 text-start">التخصص</th>
                        <th class="px-5 py-3.5 text-start">الدولة / الوفد</th>
                        <th class="px-5 py-3.5 text-start">الحالة</th>
                        <th class="px-5 py-3.5 text-end">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($registrations as $reg)
                        @php
                            $sv = is_object($reg->status) ? ($reg->status->value ?? $reg->status->name) : ($reg->status ?? 'SUBMITTED');
                            $sc = match(strtoupper($sv)) {
                                'APPROVED' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                'REJECTED' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                                default    => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition group">
                            <td class="px-5 py-3.5 font-mono font-bold text-blue-600 dark:text-blue-400">#{{ $reg->registration_code ?: 'REG-'.$reg->id }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900 dark:text-slate-100">
                                <button wire:click="openDrawer({{ $reg->id }})" class="hover:text-blue-600 transition">{{ $reg->user?->name ?? '—' }}</button>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 dark:text-slate-300 font-medium">{{ $reg->skill?->name_ar ?? '—' }}</td>
                            <td class="px-5 py-3.5 text-slate-600 dark:text-slate-300 font-medium">{{ $reg->country?->name_ar ?? '—' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $sc }}">{{ $sv }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-end">
                                <div class="flex items-center justify-end gap-1.5 opacity-90">
                                    <button wire:click="openDrawer({{ $reg->id }})" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition" title="معاينة الطلب">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="approveRegistration({{ $reg->id }})" class="p-1.5 text-slate-500 hover:text-emerald-600 rounded-lg hover:bg-slate-100 transition" title="قبول الطلب">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                    <button wire:click="openRejectModal({{ $reg->id }})" class="p-1.5 text-slate-500 hover:text-red-600 rounded-lg hover:bg-slate-100 transition" title="رفض الطلب">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $reg->id }})" class="p-1.5 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-slate-100 transition" title="حذف التسجيل نهائياً">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400 font-medium">لا توجد طلبات تسجيل مطابقة للبحث</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($registrations->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700">{{ $registrations->links() }}</div>
        @endif
    </div>

    {{-- DETAIL DRAWER --}}
    @if($drawerOpen && $selectedRegistration)
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-900/40 backdrop-blur-xs">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 border-s border-slate-200 dark:border-slate-700 h-full p-6 overflow-y-auto space-y-6 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 dark:text-slate-100">{{ $selectedRegistration->user?->name }}</h2>
                        <p class="text-xs font-bold text-blue-600 font-mono">رمز الطلب: {{ $selectedRegistration->registration_code }}</p>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-xl space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">التخصص:</span><span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedRegistration->skill?->name_ar }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">الدولة:</span><span class="font-bold text-blue-600">{{ $selectedRegistration->country?->name_ar }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">تاريخ التسجيل:</span><span class="font-bold text-slate-800 dark:text-slate-200">{{ $selectedRegistration->created_at?->format('Y-m-d H:i') }}</span></div>
                </div>
            </div>
        </div>
    @endif

    {{-- REJECT MODAL --}}
    @if($rejectModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-sm w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-xl">
                <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">سبب رفض الطلب</h3>
                <textarea wire:model="rejectionReason" rows="3" placeholder="أدخل سبب الرفض هنا..."
                    class="w-full p-3 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100"></textarea>
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('rejectModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="rejectRegistration" class="px-5 py-2 text-xs font-black text-white bg-red-600 hover:bg-red-700 rounded-xl">تأكيد الرفض</button>
                </div>
            </div>
        </div>
    @endif

    {{-- CONFIRM DELETE MODAL --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl font-bold">
                    🗑️
                </div>
                <h3 class="text-lg font-black text-slate-900">تأكيد حذف طلب التسجيل نهائياً</h3>
                <p class="text-xs text-slate-500 font-medium">هل أنت تأكد من رغبتك في حذف طلب التسجيل هذا نهائياً؟ هذا الإجراء لا يمكن التراجع عنه.</p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">
                        إلغاء
                    </button>
                    <button wire:click="deleteRegistration" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md transition">
                        تأكيد الحذف النهائي
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
