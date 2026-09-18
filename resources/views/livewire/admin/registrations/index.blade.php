@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ═════════════════════════════════════════════════════════════════════
         1. EXECUTIVE ROYAL REGISTRATIONS BANNER
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-slate-800">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/80 border border-blue-800/60 text-xs font-mono font-bold text-amber-400">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span>WORLDSKILLS ALGERIA 2026</span>
                </div>
                
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    إدارة ملفات الترشح وقوائم التسجيل
                </h1>
                
                <p class="text-xs sm:text-sm text-slate-300 font-bold max-w-2xl">
                    المعاينة والتدقيق الفوري لطلبات الترشح، طباعة قوائم المشاركين بحسب الولايات والدول، واستخراج التقارير الرسمية لأولمبياد المهن.
                </p>
            </div>

            {{-- Quick Operations Action Hub --}}
            <div class="flex items-center flex-wrap gap-3 shrink-0">
                <button 
                    onclick="window.print()" 
                    class="px-5 py-3 rounded-2xl bg-amber-600 hover:bg-amber-500 text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center gap-2 border border-amber-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>طباعة القائمة (PDF / Print)</span>
                </button>

                <button 
                    wire:click="exportExcel" 
                    class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center gap-2 border border-emerald-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>تصدير Excel (CSV)</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         2. ACTION FEEDBACK BANNER
    ═════════════════════════════════════════════════════════════════════ --}}
    @if (session()->has('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if (session()->has('warning'))
        <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-sm font-bold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif

    {{-- ═════════════════════════════════════════════════════════════════════
         3. STATISTICAL KPI METRICS GRID
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 print:hidden">
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-slate-500 dark:text-slate-400 block uppercase">إجمالي الطلبات</span>
            <span class="text-3xl font-black text-slate-900 dark:text-white tracking-tight block">{{ number_format($totalCount) }}</span>
            <span class="text-[11px] font-bold text-slate-400 block">إجمالي ملفات الترشح المسجلة</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 block uppercase">طلبات مقبولة رسمياً</span>
            <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight block">{{ number_format($approvedCount) }}</span>
            <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-500 block">{{ $totalCount > 0 ? round(($approvedCount/$totalCount)*100, 1) : 0 }}% من الطلبات</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-amber-600 dark:text-amber-400 block uppercase">قيد الانتظار والدراسة</span>
            <span class="text-3xl font-black text-amber-600 dark:text-amber-400 tracking-tight block">{{ number_format($pendingCount) }}</span>
            <span class="text-[11px] font-bold text-amber-700 dark:text-amber-500 block">تحتاج للمراجعة</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-rose-600 dark:text-rose-400 block uppercase">طلبات مرفوضة</span>
            <span class="text-3xl font-black text-rose-600 dark:text-rose-400 tracking-tight block">{{ number_format($rejectedCount) }}</span>
            <span class="text-[11px] font-bold text-rose-700 dark:text-rose-500 block">غير مستوفية للشروط</span>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         4. COMPREHENSIVE 6-FILTER CONTROL HUB (الولاية، الدولة، التخصص، الحالة، الدور)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 print:hidden">
        
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
            <h3 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                <span>تصفية وفلترة الملفات حسب المكان، الحالة، والتخصص</span>
            </h3>

            @if($search || $filterStatus || $filterWilaya || $filterCountry || $filterSkill || $filterRole)
                <button wire:click="resetFilters" class="text-xs font-black text-rose-600 hover:underline flex items-center gap-1">
                    <span>إعادة ضبط الفلاتر ✕</span>
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            
            {{-- Search Input --}}
            <div class="col-span-1 sm:col-span-2">
                <label class="block text-[10px] font-bold text-slate-500 mb-1">البحث بالاسم، الرقم، NIN، أو الهاتف</label>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="ابحث باسم المترشح، رقم التسجيل WSAP..." 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            {{-- Filter Status --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب الحالة</label>
                <select 
                    wire:model.live="filterStatus" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الحالات</option>
                    <option value="APPROVED">مقبول رسمياً (APPROVED)</option>
                    <option value="PENDING">قيد الانتظار (PENDING)</option>
                    <option value="REJECTED">مرفوض (REJECTED)</option>
                    <option value="QUALIFIED">مؤهل للمرحلة التالية</option>
                </select>
            </div>

            {{-- Filter Wilaya --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب الولاية</label>
                <select 
                    wire:model.live="filterWilaya" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الولايات (58 ولاية)</option>
                    @foreach($wilayas as $w)
                        <option value="{{ $w->id }}">{{ $w->code }} - {{ $w->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Skill --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب التخصص</label>
                <select 
                    wire:model.live="filterSkill" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع التخصصات</option>
                    @foreach($skills as $s)
                        <option value="{{ $s->id }}">{{ $s->skill_code }} - {{ $s->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Country --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب الدولة</label>
                <select 
                    wire:model.live="filterCountry" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الدول</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->iso2 }})</option>
                    @endforeach
                </select>
            </div>

        </div>

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         5. REGISTRATIONS LIST TABLE GRID (WITH VISIBLE PHOTOS)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden print:border-none print:shadow-none">
        
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 font-bold uppercase print:bg-white print:border-b-2 print:border-black">
                    <tr>
                        <th class="px-5 py-4 text-start">المترشح / المشارك</th>
                        <th class="px-5 py-4 text-start">رقم التسجيل و (NIN)</th>
                        <th class="px-5 py-4 text-start">التخصص والمهارة</th>
                        <th class="px-5 py-4 text-start">الولاية والمؤسسة</th>
                        <th class="px-5 py-4 text-center">حالة الترشح</th>
                        <th class="px-5 py-4 text-end print:hidden">إجراءات التحكم</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-bold">
                    @forelse($registrations as $reg)
                        @php
                            $p = $reg->participant;
                            $photoUrl = $reg->photo_url;
                            $statusVal = $reg->status instanceof \App\Enums\ParticipantStatus ? $reg->status->value : $reg->status;
                            $statusColor = match($statusVal) {
                                'APPROVED', 'QUALIFIED' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                'REJECTED' => 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300',
                                default => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                            };
                            $statusText = match($statusVal) {
                                'APPROVED' => 'مقبول رسمياً',
                                'QUALIFIED' => 'مؤهل للمرحلة التالية',
                                'REJECTED' => 'مرفوض',
                                default => 'قيد الانتظار',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition">
                            
                            {{-- Candidate Photo & Name --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="{{ $photoUrl }}" 
                                        alt="{{ $p?->first_name_ar }}" 
                                        class="w-12 h-12 rounded-2xl object-cover border-2 border-slate-200 dark:border-slate-700 shrink-0 shadow-sm"
                                    />
                                    <div>
                                        <h4 class="font-black text-slate-900 dark:text-white text-xs">
                                            {{ $p?->first_name_ar }} {{ $p?->last_name_ar }}
                                        </h4>
                                        <span class="text-[11px] text-slate-500 font-bold block">
                                            {{ $p?->first_name_fr }} {{ $p?->last_name_fr }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Reg Number & NIN --}}
                            <td class="px-5 py-4">
                                <div class="space-y-0.5">
                                    <span class="px-2 py-0.5 rounded-lg bg-blue-50 dark:bg-blue-950 text-[#0066FF] font-mono font-black text-[11px] inline-block">
                                        {{ $reg->registration_number }}
                                    </span>
                                    <span class="font-mono text-[11px] text-slate-500 font-bold block">
                                        NIN: {{ $p?->national_id ?? 'غير متوفر' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Skill --}}
                            <td class="px-5 py-4">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-700 dark:text-purple-300 font-bold text-xs">
                                    <span class="font-mono font-black text-[10px] bg-purple-200 dark:bg-purple-800 px-1 py-0.5 rounded">{{ $reg->skill?->skill_code ?? 'SKILL' }}</span>
                                    <span class="line-clamp-1">{{ $reg->skill?->getLocalized('name') ?? 'تخصص عام' }}</span>
                                </div>
                            </td>

                            {{-- Wilaya & Institution --}}
                            <td class="px-5 py-4">
                                <div class="space-y-0.5">
                                    <span class="text-slate-900 dark:text-white font-bold block text-xs">
                                        {{ $p?->wilaya?->name_ar ?? 'ولاية غير محددة' }}
                                    </span>
                                    <span class="text-slate-400 text-[10px] font-bold block line-clamp-1 max-w-[200px]">
                                        {{ $p?->organization?->name_ar ?? 'المؤسسة غير محددة' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-5 py-4 text-center">
                                <span class="px-3 py-1 rounded-xl text-[11px] font-black {{ $statusColor }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4 text-end print:hidden">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button 
                                        wire:click="openDrawer({{ $reg->id }})" 
                                        title="عرض التفاصيل والملف الكامل" 
                                        class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    <button 
                                        wire:click="approveRegistration({{ $reg->id }})" 
                                        title="قبول الطلب رسمياً" 
                                        class="p-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>

                                    <button 
                                        wire:click="openRejectModal({{ $reg->id }})" 
                                        title="رفض الطلب" 
                                        class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 dark:bg-rose-950 text-rose-600 dark:text-rose-400 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>

                                    <button 
                                        wire:click="confirmDelete({{ $reg->id }})" 
                                        title="حذف التسجيل نهائياً" 
                                        class="p-2 rounded-xl bg-slate-100 hover:bg-rose-100 text-slate-400 hover:text-rose-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-bold">
                                لا توجد ملفات ترشح مطابقة لفلاتر البحث المحددة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-700 print:hidden">
                {{ $registrations->links() }}
            </div>
        @endif

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         6. CANDIDATE FULL DOSSIER DRAWER
    ═════════════════════════════════════════════════════════════════════ --}}
    @if($drawerOpen && $selectedRegistration)
        @php
            $dp = $selectedRegistration->participant;
        @endphp
        <div class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm flex items-center justify-end p-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-lg w-full h-full p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-6 overflow-y-auto">
                
                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex items-center gap-4">
                        <img 
                            src="{{ $selectedRegistration->photo_url }}" 
                            alt="{{ $dp?->first_name_ar }}" 
                            class="w-16 h-16 rounded-2xl object-cover border-2 border-blue-600 shadow-md"
                        />
                        <div>
                            <span class="px-2.5 py-0.5 rounded-md bg-blue-100 dark:bg-blue-950 text-[#0066FF] font-mono font-black text-xs">
                                {{ $selectedRegistration->registration_number }}
                            </span>
                            <h2 class="text-lg font-black text-slate-900 dark:text-white mt-1">
                                {{ $dp?->first_name_ar }} {{ $dp?->last_name_ar }}
                            </h2>
                            <p class="text-xs text-slate-500 font-bold">
                                {{ $dp?->first_name_fr }} {{ $dp?->last_name_fr }}
                            </p>
                        </div>
                    </div>

                    <button wire:click="closeDrawer" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 flex items-center justify-center font-black">✕</button>
                </div>

                {{-- Personal Identity & Sizes --}}
                <div class="space-y-4 text-xs font-bold">
                    
                    <div class="space-y-2">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">جدول القياسات الشخصية</h4>
                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                                <span class="text-slate-400 block text-[10px]">قياس البدلة</span>
                                <span class="text-base font-black text-slate-900 dark:text-white mt-1 block">{{ $selectedRegistration->suit_size ?? 'غير محدد' }}</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                                <span class="text-slate-400 block text-[10px]">قياس الحذاء</span>
                                <span class="text-base font-black text-slate-900 dark:text-white mt-1 block">{{ $selectedRegistration->shoe_size ?? 'غير محدد' }}</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                                <span class="text-slate-400 block text-[10px]">القامة (سم)</span>
                                <span class="text-base font-black text-slate-900 dark:text-white mt-1 block">{{ $selectedRegistration->height_cm ? $selectedRegistration->height_cm . ' سم' : 'غير محدد' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">معلومات الهوية والجهة</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                                <span class="text-slate-400 block text-[10px]">رقم التعريف (NIN)</span>
                                <span class="font-mono font-black text-slate-900 dark:text-white text-xs">{{ $dp?->national_id ?? 'غير متوفر' }}</span>
                            </div>
                            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                                <span class="text-slate-400 block text-[10px]">رقم الهاتف</span>
                                <span class="font-mono font-black text-slate-900 dark:text-white text-xs">{{ $dp?->phone ?? 'غير متوفر' }}</span>
                            </div>
                            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                                <span class="text-slate-400 block text-[10px]">الولاية</span>
                                <span class="font-black text-slate-900 dark:text-white text-xs">{{ $dp?->wilaya?->name_ar ?? 'غير محددة' }}</span>
                            </div>
                            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                                <span class="text-slate-400 block text-[10px]">الدولة</span>
                                <span class="font-black text-slate-900 dark:text-white text-xs">{{ $selectedRegistration->country?->name_ar ?? 'الجزائر' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                        <span class="text-slate-400 block text-[10px]">المؤسسة التكوينية</span>
                        <span class="font-black text-slate-900 dark:text-white text-xs">{{ $dp?->organization?->name_ar ?? 'غير محددة' }}</span>
                    </div>

                    <div class="p-3 rounded-xl bg-purple-50 dark:bg-purple-950/40 border border-purple-200 dark:border-purple-800 flex items-center justify-between">
                        <div>
                            <span class="text-purple-600 dark:text-purple-400 block text-[10px]">التخصص الأولمبي</span>
                            <span class="font-black text-slate-900 dark:text-white text-xs">{{ $selectedRegistration->skill?->getLocalized('name') ?? 'تخصص عام' }}</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-purple-600 text-white font-mono font-black text-xs">
                            {{ $selectedRegistration->skill?->skill_code }}
                        </span>
                    </div>

                </div>

                {{-- Action Footer --}}
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                    <button wire:click="closeDrawer" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs">
                        إغلاق
                    </button>
                    <div class="flex items-center gap-2">
                        <button wire:click="approveRegistration({{ $selectedRegistration->id }})" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-black text-xs">
                            قبول الترشح
                        </button>
                        <button wire:click="openRejectModal({{ $selectedRegistration->id }})" class="px-4 py-2.5 rounded-xl bg-rose-600 text-white font-black text-xs">
                            رفض الطلب
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif

    {{-- REJECT MODAL --}}
    @if($rejectModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 max-w-sm w-full space-y-4 border border-slate-200 dark:border-slate-800 shadow-xl">
                <h3 class="text-base font-black text-rose-600">سبب رفض طلب الترشح</h3>
                <textarea wire:model="rejectionReason" rows="3" placeholder="أدخل سبب الرفض الميداني هنا..."
                    class="w-full p-3 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-slate-100"></textarea>
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('rejectModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 rounded-xl">إلغاء</button>
                    <button wire:click="rejectRegistration" class="px-5 py-2.5 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الرفض</button>
                </div>
            </div>
        </div>
    @endif

    {{-- CONFIRM DELETE MODAL --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 w-full max-w-sm shadow-2xl border border-slate-200 dark:border-slate-800 text-center space-y-4">
                <h3 class="text-base font-black text-rose-600">تأكيد حذف ملف الترشح نهائياً</h3>
                <p class="text-xs text-slate-500 font-bold">هل أنت تأكد من رغبتك في حذف هذا التسجيل نهائياً؟ لا يمكن التراجع عن هذا الإجراء.</p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 rounded-xl">
                        إلغاء
                    </button>
                    <button wire:click="deleteRegistration" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md">
                        تأكيد الحذف النهائي
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
