@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ═════════════════════════════════════════════════════════════════════
         1. EXECUTIVE ROYAL PARTICIPANTS BANNER
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
                    دليل المشاركين والمترشحين المعتمدين
                </h1>
                
                <p class="text-xs sm:text-sm text-slate-300 font-bold max-w-2xl">
                    سجل حصر ودليل المشاركين المقبولين رسمياً للمشاركة في الألعاب والمنافسات الوطنية والدولية مع إمكانيات الفلترة والتصدير وطباعة شارات الاعتماد.
                </p>
            </div>

            {{-- Quick Operations Action Hub --}}
            <div class="flex items-center flex-wrap gap-3 shrink-0">
                <button 
                    wire:click="exportPdf" 
                    class="px-5 py-3 rounded-2xl bg-amber-600 hover:bg-amber-500 text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center gap-2 border border-amber-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>طباعة قائمة PDF</span>
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

    {{-- ═════════════════════════════════════════════════════════════════════
         3. EXACT STATISTICAL KPI METRICS GRID (المشاركون المعتمدون حصراً)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-slate-500 dark:text-slate-400 block uppercase">إجمالي المشاركين المعتمدين</span>
            <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight block">{{ number_format($totalApproved) }}</span>
            <span class="text-[11px] font-bold text-slate-400 block">مقبولون ومؤهلون للمنافسات</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-blue-600 dark:text-blue-400 block uppercase">عدد الذكور المقبولين</span>
            <span class="text-3xl font-black text-blue-600 dark:text-blue-400 tracking-tight block">{{ number_format($maleApproved) }}</span>
            <span class="text-[11px] font-bold text-blue-700 dark:text-blue-500 block">{{ $totalApproved > 0 ? round(($maleApproved/$totalApproved)*100, 1) : 0 }}% من المشاركين المعتمدين</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-purple-600 dark:text-purple-400 block uppercase">عدد الإناث المقبولات</span>
            <span class="text-3xl font-black text-purple-600 dark:text-purple-400 tracking-tight block">{{ number_format($femaleApproved) }}</span>
            <span class="text-[11px] font-bold text-purple-700 dark:text-purple-500 block">{{ $totalApproved > 0 ? round(($femaleApproved/$totalApproved)*100, 1) : 0 }}% من المشاركين المعتمدين</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-amber-600 dark:text-amber-400 block uppercase">التخصصات والمهارات</span>
            <span class="text-3xl font-black text-amber-600 dark:text-amber-400 tracking-tight block">{{ number_format($totalSkills) }}</span>
            <span class="text-[11px] font-bold text-amber-700 dark:text-amber-500 block">مهارات ومجالات تنافسية</span>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         4. FILTERS & SEARCH CONTROL HUB (الولاية، الدولة، التخصص، الجنس، البحث)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
        
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
            <h3 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <span>تصفية وفلترة قوائم المشاركين المعتمدين</span>
            </h3>

            @if($search || $filterWilaya || $filterCountry || $filterSkill || $filterGender)
                <button wire:click="resetFilters" class="text-xs font-black text-rose-600 hover:underline flex items-center gap-1">
                    <span>إعادة ضبط الفلاتر ✕</span>
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            
            {{-- Filter 1: Search --}}
            <div class="col-span-1 sm:col-span-2">
                <label class="block text-[10px] font-bold text-slate-500 mb-1">البحث بالاسم، رقم التسجيل، NIN، أو الهاتف</label>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="ابحث برقم التسجيل WSAP-، الاسم، البريد..." 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            {{-- Filter 2: Wilaya --}}
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

            {{-- Filter 3: Country --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب الدولة</label>
                <select 
                    wire:model.live="filterCountry" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الدول</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter 4: Skill --}}
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

            {{-- Filter 5: Gender --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب الجنس</label>
                <select 
                    wire:model.live="filterGender" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع المشاركين (ذكور وإناث)</option>
                    <option value="MALE">الذكور فقط</option>
                    <option value="FEMALE">الإناث فقط</option>
                </select>
            </div>

        </div>

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         5. APPROVED PARTICIPANTS TABLE GRID
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 font-bold uppercase">
                    <tr>
                        <th class="px-5 py-4 text-start">المشارك المعتمد</th>
                        <th class="px-5 py-4 text-start">الجنس والصفة</th>
                        <th class="px-5 py-4 text-start">التخصص والمهارة</th>
                        <th class="px-5 py-4 text-start">الولاية / الدولة</th>
                        <th class="px-5 py-4 text-start">الاتصال ورقم NIN</th>
                        <th class="px-5 py-4 text-center">حالة الاعتماد</th>
                        <th class="px-5 py-4 text-end">التفاصيل والإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-bold">
                    @forelse($registrations as $reg)
                        @php
                            $p = $reg->participant;
                            $photoUrl = $reg->photo_url;
                            $isFemale = in_array(strtolower($p?->gender ?? ''), ['female', 'أنثى']);
                            $badgeRoute = route('accreditation.badge', ['identifier' => $reg->registration_number]);
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition">
                            
                            {{-- Participant Photo & Identity --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="{{ $photoUrl }}" 
                                        alt="{{ $p?->first_name_ar }}" 
                                        class="w-11 h-11 rounded-xl object-cover border-2 border-emerald-500 shrink-0 shadow-xs"
                                    />
                                    <div class="space-y-0.5">
                                        <span class="px-2 py-0.5 rounded bg-blue-50 dark:bg-blue-950 text-[#0066FF] font-mono font-black text-[10px] inline-block">
                                            {{ $reg->registration_number }}
                                        </span>
                                        <h4 class="font-black text-slate-900 dark:text-white text-xs">
                                            {{ $p?->first_name_ar }} {{ $p?->last_name_ar }}
                                        </h4>
                                        <span class="font-mono text-[10px] text-slate-400 block font-normal">
                                            {{ $p?->first_name_fr }} {{ $p?->last_name_fr }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Gender & Status Tag --}}
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-xl text-[11px] font-black {{ $isFemale ? 'bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300' }}">
                                    {{ $isFemale ? 'أنثى' : 'ذكر' }}
                                </span>
                            </td>

                            {{-- Skill --}}
                            <td class="px-5 py-4">
                                <div class="space-y-0.5">
                                    <span class="font-black text-slate-900 dark:text-white text-xs block">
                                        {{ $reg->skill?->getLocalized('name') ?? 'تخصص عام' }}
                                    </span>
                                    <span class="font-mono text-[10px] font-black text-purple-600 dark:text-purple-400 block">
                                        {{ $reg->skill?->skill_code }}
                                    </span>
                                </div>
                            </td>

                            {{-- Location --}}
                            <td class="px-5 py-4">
                                <div class="space-y-0.5">
                                    <span class="text-slate-900 dark:text-white block text-xs">
                                        {{ $p?->wilaya?->name_ar ?? 'ولاية غير محددة' }}
                                    </span>
                                    <span class="text-slate-400 text-[10px] font-mono block">
                                        {{ $reg->country?->name_ar ?? 'الجزائر (DZ)' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Contact & NIN --}}
                            <td class="px-5 py-4">
                                <div class="space-y-0.5">
                                    <span class="font-mono text-slate-900 dark:text-white block text-xs font-black">
                                        {{ $p?->phone ?? 'غير متوفر' }}
                                    </span>
                                    <span class="font-mono text-[10px] text-slate-400 block">
                                        NIN: {{ $p?->national_id ?? 'غير متوفر' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-5 py-4 text-center">
                                <span class="px-3 py-1 rounded-xl text-[11px] font-black bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                    مقبول ومعتمد ✓
                                </span>
                            </td>

                            {{-- Actions (Badge Icon, Details, Delete) --}}
                            <td class="px-5 py-4 text-end">
                                <div class="flex items-center justify-end gap-1.5">
                                    
                                    {{-- Accreditation Badge Icon Button --}}
                                    <a 
                                        href="{{ $badgeRoute }}" 
                                        target="_blank" 
                                        title="عرض وطباعة شارة الاعتماد الرسمية (Badge)" 
                                        class="p-2 rounded-xl bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 transition border border-amber-200 dark:border-amber-800/60">
                                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>

                                    {{-- View Details --}}
                                    <button 
                                        wire:click="openDrawer({{ $reg->id }})" 
                                        title="عرض التفاصيل والملفات" 
                                        class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    {{-- Delete --}}
                                    <button 
                                        wire:click="confirmDelete({{ $reg->id }})" 
                                        title="حذف الملف" 
                                        class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 dark:bg-rose-950 text-rose-600 dark:text-rose-400 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-bold">
                                لم يتم العثور على أي مشاركين معتمدين يطابقون فلاتر البحث المحددة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-700">
                {{ $registrations->links() }}
            </div>
        @endif

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         6. PARTICIPANT DETAILS DRAWER
    ═════════════════════════════════════════════════════════════════════ --}}
    @if($drawerOpen && $selected)
        @php
            $sp = $selected->participant;
            $sBadgeRoute = route('accreditation.badge', ['identifier' => $selected->registration_number]);
        @endphp
        <div class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm flex items-center justify-end p-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-lg w-full h-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-6 overflow-y-auto">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ $selected->photo_url }}" alt="{{ $sp?->first_name_ar }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-emerald-500">
                        <div>
                            <span class="px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-950 text-[#0066FF] font-mono font-black text-xs">
                                {{ $selected->registration_number }}
                            </span>
                            <h3 class="font-black text-slate-900 dark:text-white text-base mt-1">{{ $sp?->first_name_ar }} {{ $sp?->last_name_ar }}</h3>
                            <span class="font-mono text-xs text-slate-400">{{ $sp?->first_name_fr }} {{ $sp?->last_name_fr }}</span>
                        </div>
                    </div>
                    <button wire:click="closeDrawer" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 flex items-center justify-center font-black">✕</button>
                </div>

                <div class="space-y-4 text-xs font-bold">
                    
                    {{-- Accreditation Badge Button --}}
                    <a 
                        href="{{ $sBadgeRoute }}" 
                        target="_blank" 
                        class="w-full py-3 rounded-2xl bg-amber-600 hover:bg-amber-500 text-white font-black text-xs transition shadow-md flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>عرض وطباعة شارة الاعتماد الرسمية (Badge 2026)</span>
                    </a>

                    <div class="p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center justify-between">
                        <span>حالة الاعتماد بالحساب:</span>
                        <span class="px-3 py-1 rounded-xl text-xs font-black bg-emerald-600 text-white">
                            مقبول ومعتمد رسمياً ✓
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/40">
                            <span class="text-slate-400 block text-[10px]">قياس البدلة</span>
                            <span class="font-black text-slate-900 dark:text-white text-sm mt-0.5 block">{{ $selected->suit_size ?? '—' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/40">
                            <span class="text-slate-400 block text-[10px]">قياس الحذاء</span>
                            <span class="font-black text-slate-900 dark:text-white text-sm mt-0.5 block">{{ $selected->shoe_size ?? '—' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/40">
                            <span class="text-slate-400 block text-[10px]">القامة (سم)</span>
                            <span class="font-black text-slate-900 dark:text-white text-sm mt-0.5 block">{{ $selected->height_cm ? $selected->height_cm . ' سم' : '—' }}</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                            <span class="text-slate-400 block text-[10px]">رقم التعريف الوطني (NIN)</span>
                            <span class="font-mono font-black text-slate-900 dark:text-white text-sm">{{ $sp?->national_id ?? 'غير متوفر' }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                            <span class="text-slate-400 block text-[10px]">الولاية والمؤسسة التكوينية</span>
                            <span class="font-black text-slate-900 dark:text-white text-xs">{{ $sp?->wilaya?->name_ar ?? 'غير محددة' }} - {{ $sp?->organization?->name_ar ?? 'المؤسسة غير محددة' }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                            <span class="text-slate-400 block text-[10px]">رقم الهاتف والاتصال</span>
                            <span class="font-mono font-black text-slate-900 dark:text-white text-xs">{{ $sp?->phone ?? 'غير متوفر' }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button wire:click="closeDrawer" class="w-full py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 font-bold text-xs text-slate-700 dark:text-slate-300">
                        إغلاق النافذة
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ════ DELETE CONFIRMATION MODAL ════ --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 w-full max-w-sm shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4 text-center">
                <h3 class="text-base font-black text-rose-600">تأكيد حذف الملف المعتمد</h3>
                <p class="text-xs text-slate-500 font-bold">هل أنت تأكد من رغبتك في حذف هذا المشارك نهائياً من قاعدة البيانات؟ لا يمكن التراجع عن هذا الإجراء.</p>

                <div class="flex items-center justify-center gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 rounded-xl">إلغاء</button>
                    <button wire:click="deleteParticipant" class="px-6 py-2.5 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif

</div>
