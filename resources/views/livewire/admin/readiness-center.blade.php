@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ═════════════════════════════════════════════════════════════════════
         1. EXECUTIVE ROYAL HEADER BANNER
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-slate-800">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-950/80 border border-emerald-800/60 text-xs font-mono font-bold text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>WORLDSKILLS ALGERIA 2026</span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    مؤشر جاهزية المترشحين المقبولين
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 font-bold max-w-2xl">
                    متابعة دقيقة واستكمال فوري لكافة البيانات الشخصية، القياسات (البدلة/الحذاء/القامة)، ورقم التعريف الوطني (NIN) للمترشحين المقبولين رسمياً.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button 
                    wire:click="sendBulkReminders" 
                    wire:confirm="هل أنت تأكد من إرسال إشعارات تذكير جماعية لجميع المترشحين غير المستوفين للبيانات والقياسات؟"
                    class="px-5 py-3 rounded-2xl bg-amber-600 hover:bg-amber-500 text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center gap-2 border border-amber-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span>إرسال تذكير جماعي للمتخلفين</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         2. ACTION FEEDBACK NOTIFICATION BANNER
    ═════════════════════════════════════════════════════════════════════ --}}
    @if($actionFeedback)
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $actionFeedback }}</span>
            </div>
            <button wire:click="$set('actionFeedback', '')" class="text-xs text-slate-400 hover:text-slate-600">إغلاق ✕</button>
        </div>
    @endif

    {{-- ═════════════════════════════════════════════════════════════════════
         3. STATISTICAL KPI METRICS GRID
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-slate-500 dark:text-slate-400 block uppercase">إجمالي المقبولين</span>
            <span class="text-2xl font-black text-slate-900 dark:text-white tracking-tight block">{{ number_format($totalApprovedCount) }}</span>
            <span class="text-[11px] font-bold text-slate-400 block">مترشح مقبول رسمياً</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 block uppercase">جاهز ومكتمل 100%</span>
            <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight block">{{ number_format($fullyCompleteCount) }}</span>
            <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-500 block">{{ $totalApprovedCount > 0 ? round(($fullyCompleteCount/$totalApprovedCount)*100, 1) : 0 }}% من الإجمالي</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-amber-600 dark:text-amber-400 block uppercase">ملفات غير مكتملة</span>
            <span class="text-2xl font-black text-amber-600 dark:text-amber-400 tracking-tight block">{{ number_format($incompleteCount) }}</span>
            <span class="text-[11px] font-bold text-amber-700 dark:text-amber-500 block">يحتاجون استكمال</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-rose-600 dark:text-rose-400 block uppercase">ينقصهم القياسات</span>
            <span class="text-2xl font-black text-rose-600 dark:text-rose-400 tracking-tight block">{{ number_format($missingSizesCount) }}</span>
            <span class="text-[11px] font-bold text-rose-700 dark:text-rose-500 block">بدلة / حذاء / قامة</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-purple-600 dark:text-purple-400 block uppercase">ينقصهم (NIN)</span>
            <span class="text-2xl font-black text-purple-600 dark:text-purple-400 tracking-tight block">{{ number_format($missingNinCount) }}</span>
            <span class="text-[11px] font-bold text-purple-700 dark:text-purple-500 block">بدون تعريف وطني</span>
        </div>

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         4. FILTERS & SEARCH CONTROL HUB
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-5">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            {{-- Search Input --}}
            <div class="relative">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="بحث باسم المترشح، رقم التسجيل، NIN، أو الهاتف..." 
                    class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            {{-- Wilaya Filter --}}
            <div>
                <select 
                    wire:model.live="wilayaFilter" 
                    class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الولايات (كل الجزائر)</option>
                    @foreach($wilayas as $w)
                        <option value="{{ $w->id }}">{{ $w->code }} - {{ $w->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Skill Filter --}}
            <div>
                <select 
                    wire:model.live="skillFilter" 
                    class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع التخصصات والمهارات</option>
                    @foreach($skills as $s)
                        <option value="{{ $s->id }}">{{ $s->skill_code }} - {{ $s->name_ar }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Readiness Filter Tabs --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 pt-1">
            <button 
                wire:click="$set('readinessFilter', 'all')" 
                class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap {{ $readinessFilter === 'all' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-md' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200' }}">
                جميع المترشحين المقبولين ({{ number_format($totalApprovedCount) }})
            </button>

            <button 
                wire:click="$set('readinessFilter', 'complete')" 
                class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap {{ $readinessFilter === 'complete' ? 'bg-emerald-600 text-white shadow-md' : 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100' }}">
                مكتمل وجاهز 100% ({{ number_format($fullyCompleteCount) }})
            </button>

            <button 
                wire:click="$set('readinessFilter', 'incomplete')" 
                class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap {{ $readinessFilter === 'incomplete' ? 'bg-amber-600 text-white shadow-md' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 hover:bg-amber-100' }}">
                غير مكتمل ({{ number_format($incompleteCount) }})
            </button>

            <button 
                wire:click="$set('readinessFilter', 'missing_sizes')" 
                class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap {{ $readinessFilter === 'missing_sizes' ? 'bg-rose-600 text-white shadow-md' : 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 hover:bg-rose-100' }}">
                ينقصه القياسات ({{ number_format($missingSizesCount) }})
            </button>

            <button 
                wire:click="$set('readinessFilter', 'missing_nin')" 
                class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap {{ $readinessFilter === 'missing_nin' ? 'bg-purple-600 text-white shadow-md' : 'bg-purple-50 dark:bg-purple-950/40 text-purple-700 dark:text-purple-400 hover:bg-purple-100' }}">
                ينقصه رقم NIN ({{ number_format($missingNinCount) }})
            </button>
        </div>

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         5. CANDIDATES LIST GRID / CARDS
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="space-y-4">
        
        @forelse($candidates as $reg)
            @php
                $p = $reg->participant;
                $hasNin = !empty($p?->national_id);
                $hasSuit = !empty($reg->suit_size);
                $hasShoe = !empty($reg->shoe_size);
                $hasHeight = !empty($reg->height_cm);
                $hasPhone = !empty($p?->phone);
                
                $isComplete = $hasNin && $hasSuit && $hasShoe && $hasHeight;
                $photoUrl = $reg->photo_url;
            @endphp

            <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm transition hover:shadow-md flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                
                {{-- Candidate Info Header --}}
                <div class="flex items-center gap-4 min-w-[280px]">
                    <div class="relative shrink-0">
                        <img 
                            src="{{ $photoUrl }}" 
                            alt="{{ $p?->first_name_ar }}" 
                            class="w-16 h-16 rounded-2xl object-cover border-2 {{ $isComplete ? 'border-emerald-500' : 'border-amber-500' }} shadow-md"
                        />
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full {{ $isComplete ? 'bg-emerald-500' : 'bg-amber-500' }} border-2 border-white dark:border-slate-800 flex items-center justify-center text-[10px] text-white font-black">
                            {{ $isComplete ? '✓' : '!' }}
                        </span>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-[#0066FF] font-mono font-black text-[11px]">
                                {{ $reg->registration_number }}
                            </span>
                            <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-[11px]">
                                {{ $p?->wilaya?->name_ar ?? 'ولاية غير محددة' }}
                            </span>
                        </div>

                        <h3 class="text-base font-black text-slate-900 dark:text-white tracking-tight">
                            {{ $p?->first_name_ar }} {{ $p?->last_name_ar }}
                        </h3>

                        <p class="text-xs text-slate-500 font-bold line-clamp-1">
                            {{ $p?->organization?->name_ar ?? 'المؤسسة التكوينية غير محددة' }}
                        </p>
                    </div>
                </div>

                {{-- Skill & Contact Details --}}
                <div class="space-y-1.5 min-w-[200px]">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-700 dark:text-purple-300 font-bold text-xs">
                        <span class="font-mono font-black text-[10px] bg-purple-200 dark:bg-purple-800 px-1.5 py-0.5 rounded">{{ $reg->skill?->skill_code ?? 'SKILL' }}</span>
                        <span>{{ $reg->skill?->getLocalized('name') ?? 'تخصص عام' }}</span>
                    </div>

                    <div class="flex items-center gap-3 text-xs font-bold text-slate-600 dark:text-slate-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <a href="tel:{{ $p?->phone }}" class="hover:text-blue-600 font-mono">{{ $p?->phone ?? 'غير متوفر' }}</a>
                        </span>
                    </div>
                </div>

                {{-- Specific Readiness Badges (NIN, Suit, Shoe, Height) --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center min-w-[320px]">
                    
                    {{-- NIN --}}
                    <div class="p-2 rounded-xl {{ $hasNin ? 'bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800' : 'bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800' }}">
                        <span class="text-[10px] font-bold text-slate-500 block">تعريف وطني (NIN)</span>
                        <span class="text-xs font-black {{ $hasNin ? 'text-emerald-700 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ $hasNin ? 'مكتمل ✓' : 'ناقص ✕' }}
                        </span>
                    </div>

                    {{-- Suit Size --}}
                    <div class="p-2 rounded-xl {{ $hasSuit ? 'bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800' : 'bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800' }}">
                        <span class="text-[10px] font-bold text-slate-500 block">قياس البدلة</span>
                        <span class="text-xs font-black {{ $hasSuit ? 'text-emerald-700 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                            {{ $hasSuit ? $reg->suit_size : 'غير محدد' }}
                        </span>
                    </div>

                    {{-- Shoe Size --}}
                    <div class="p-2 rounded-xl {{ $hasShoe ? 'bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800' : 'bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800' }}">
                        <span class="text-[10px] font-bold text-slate-500 block">قياس الحذاء</span>
                        <span class="text-xs font-black {{ $hasShoe ? 'text-emerald-700 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                            {{ $hasShoe ? $reg->shoe_size : 'غير محدد' }}
                        </span>
                    </div>

                    {{-- Height --}}
                    <div class="p-2 rounded-xl {{ $hasHeight ? 'bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800' : 'bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800' }}">
                        <span class="text-[10px] font-bold text-slate-500 block">القامة (سم)</span>
                        <span class="text-xs font-black {{ $hasHeight ? 'text-emerald-700 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                            {{ $hasHeight ? $reg->height_cm . ' سم' : 'غير محدد' }}
                        </span>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2 shrink-0">
                    <button 
                        wire:click="viewCandidateDetails({{ $reg->id }})" 
                        class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-black text-xs transition flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>التفاصيل</span>
                    </button>

                    <button 
                        wire:click="sendCandidateReminder({{ $reg->id }})" 
                        title="إرسال تذكير استكمال البيانات"
                        class="px-3 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span>تذكير</span>
                    </button>
                </div>

            </div>
        @empty
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-12 text-center border border-slate-200 dark:border-slate-700">
                <svg class="w-12 h-12 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-base font-black text-slate-900 dark:text-white">لم يتم العثور على أي نتائج</h3>
                <p class="text-xs text-slate-500 font-bold mt-1">جرب تغيير محددات البحث أو خيارات التصفية بالكسر الإداري.</p>
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $candidates->links() }}
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         6. CANDIDATE FULL DETAILS MODAL
    ═════════════════════════════════════════════════════════════════════ --}}
    @if($showDetailsModal && $selectedRegistration)
        @php
            $sp = $selectedRegistration->participant;
            $sHasNin = !empty($sp?->national_id);
            $sHasSuit = !empty($selectedRegistration->suit_size);
            $sHasShoe = !empty($selectedRegistration->shoe_size);
            $sHasHeight = !empty($selectedRegistration->height_cm);
            $sIsComplete = $sHasNin && $sHasSuit && $sHasShoe && $sHasHeight;
        @endphp

        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
            
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-6 relative max-h-[90vh] overflow-y-auto">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex items-center gap-3">
                        <img 
                            src="{{ $selectedRegistration->photo_url }}" 
                            alt="{{ $sp?->first_name_ar }}" 
                            class="w-14 h-14 rounded-2xl object-cover border-2 border-blue-600 shadow-md"
                        />
                        <div>
                            <span class="px-2.5 py-0.5 rounded-md bg-blue-100 dark:bg-blue-950 text-[#0066FF] font-mono font-black text-xs">
                                {{ $selectedRegistration->registration_number }}
                            </span>
                            <h2 class="text-lg font-black text-slate-900 dark:text-white mt-1">
                                {{ $sp?->first_name_ar }} {{ $sp?->last_name_ar }}
                            </h2>
                            <p class="text-xs text-slate-500 font-bold">
                                {{ $sp?->first_name_fr }} {{ $sp?->last_name_fr }}
                            </p>
                        </div>
                    </div>

                    <button wire:click="closeDetailsModal" class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-500 flex items-center justify-center text-sm font-black">
                        ✕
                    </button>
                </div>

                {{-- Status Badge Header --}}
                <div class="p-4 rounded-2xl {{ $sIsComplete ? 'bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300' : 'bg-amber-50 dark:bg-amber-950/50 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300' }} text-xs font-bold flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full {{ $sIsComplete ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                        <span>حالة الاستكمال: <strong>{{ $sIsComplete ? 'الملف الشخصي والقياسات مكتملة 100%' : 'الملف غير مكتمل - ينقصه بعض البيانات والقياسات' }}</strong></span>
                    </div>
                </div>

                {{-- Measurements Grid --}}
                <div class="space-y-3">
                    <h3 class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">جدول القياسات والتجهيزات الشخصية</h3>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-center">
                            <span class="text-xs text-slate-500 font-bold block">قياس البدلة</span>
                            <span class="text-lg font-black text-slate-900 dark:text-white mt-1 block">{{ $selectedRegistration->suit_size ?? 'غير محدد' }}</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-center">
                            <span class="text-xs text-slate-500 font-bold block">قياس الحذاء</span>
                            <span class="text-lg font-black text-slate-900 dark:text-white mt-1 block">{{ $selectedRegistration->shoe_size ?? 'غير محدد' }}</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-center">
                            <span class="text-xs text-slate-500 font-bold block">القامة (سم)</span>
                            <span class="text-lg font-black text-slate-900 dark:text-white mt-1 block">{{ $selectedRegistration->height_cm ? $selectedRegistration->height_cm . ' سم' : 'غير محدد' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Personal Identity Info Grid --}}
                <div class="space-y-3">
                    <h3 class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">بيانات الهوية والاتصال</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 font-bold block text-[10px]">رقم التعريف الوطني (NIN)</span>
                            <span class="font-mono font-black text-slate-900 dark:text-white text-sm">{{ $sp?->national_id ?? 'غير متوفر' }}</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 font-bold block text-[10px]">رقم الهاتف</span>
                            <span class="font-mono font-black text-slate-900 dark:text-white text-sm">{{ $sp?->phone ?? 'غير متوفر' }}</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 font-bold block text-[10px]">البريد الإلكتروني</span>
                            <span class="font-mono font-black text-slate-900 dark:text-white text-xs">{{ $sp?->email ?? 'غير متوفر' }}</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 font-bold block text-[10px]">تاريخ الميلاد</span>
                            <span class="font-mono font-black text-slate-900 dark:text-white text-xs">{{ $sp?->date_of_birth ?? 'غير متوفر' }}</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 font-bold block text-[10px]">الولاية</span>
                            <span class="font-black text-slate-900 dark:text-white text-xs">{{ $sp?->wilaya?->name_ar ?? 'غير محددة' }}</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 font-bold block text-[10px]">المؤسسة التكوينية / المركز</span>
                            <span class="font-black text-slate-900 dark:text-white text-xs line-clamp-1">{{ $sp?->organization?->name_ar ?? 'غير محددة' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Skill Details --}}
                <div class="p-4 rounded-2xl bg-purple-50 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-800/50 flex items-center justify-between text-xs">
                    <div>
                        <span class="text-purple-600 dark:text-purple-400 font-bold block text-[10px]">التخصص والأولمبياد</span>
                        <h4 class="font-black text-slate-900 dark:text-white text-sm mt-0.5">{{ $selectedRegistration->skill?->getLocalized('name') ?? 'تخصص عام' }}</h4>
                    </div>
                    <span class="px-3 py-1 rounded-xl bg-purple-600 text-white font-mono font-black text-xs">
                        {{ $selectedRegistration->skill?->skill_code }}
                    </span>
                </div>

                {{-- Action Footer --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button wire:click="closeDetailsModal" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs">
                        إغلاق النافذة
                    </button>

                    <button 
                        wire:click="sendCandidateReminder({{ $selectedRegistration->id }})" 
                        class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-black text-xs transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span>إرسال إشعار تذكير للمترشح</span>
                    </button>
                </div>

            </div>

        </div>
    @endif

</div>
