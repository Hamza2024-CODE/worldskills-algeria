<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" x-data="{ showPdfReader: false, currentPdfUrl: '' }">

    {{-- ===== HEADER ===== --}}
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#EEF6FF] border border-[#0066FF]/30 flex items-center justify-center text-[#0066FF] shadow-sm">
                <svg class="w-8 h-8 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-black text-[#06205C] tracking-wide">{{ __('messages.guide_regulations_title') }} — WorldSkills Algeria</h1>
                <p class="text-xs text-[#0066FF] font-bold mt-0.5">{{ __('messages.guide_regulations_subtitle') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button @click="currentPdfUrl = '{{ route('td.viewer', ['key' => $activeSection]) }}'; showPdfReader = true;" class="px-4 py-2 rounded-2xl bg-[#0066FF] hover:bg-[#0052CC] text-white text-xs font-black shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Consulter le document (Lecteur PDF)' : (app()->getLocale() === 'en' ? 'Read Official Document (PDF Viewer)' : 'استعراض الكراسة الرسمية (قارئ المستند المباشر)') }}</span>
            </button>
        </div>
    </div>

    {{-- ===== MAIN GRID ===== --}}
    {{-- ===== MAIN GRID ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        {{-- NAV SIDEBAR --}}
        <!-- Mobile Collapsible Selector Bar (Only on mobile screens < lg) -->
        <div x-data="{ mobileNavOpen: false }" class="lg:hidden col-span-1 bg-white p-4 rounded-3xl border border-slate-200 shadow-lg space-y-3">
            <button @click="mobileNavOpen = !mobileNavOpen" type="button" class="w-full flex items-center justify-between px-4 py-3 rounded-2xl bg-blue-50 text-[#0066FF] font-black text-xs border border-blue-200">
                <div class="flex items-center gap-2 truncate">
                    <svg class="w-4 h-4 text-[#0066FF] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <span class="truncate">{{ $currentSection ? $currentSection->getLocalizedTitle() : __('messages.guide_sections_nav') }}</span>
                </div>
                <svg class="w-4 h-4 transition-transform shrink-0" :class="mobileNavOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div x-show="mobileNavOpen" x-collapse class="space-y-1.5 pt-2 border-t border-slate-100 max-h-80 overflow-y-auto">
                @foreach($generalSections as $i => $sec)
                    <button
                        wire:click="setSection('{{ $sec->section_key }}'); mobileNavOpen = false;"
                        class="w-full text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-4 py-2.5 rounded-2xl text-xs font-black transition-all {{ ($activeSection === $sec->section_key && $activeSection !== 'skills_td') ? 'bg-[#0066FF] text-white shadow-md' : 'text-slate-700 hover:bg-slate-50' }}"
                    >
                        {{ ($i + 1) }}. {{ $sec->getLocalizedTitle() }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Desktop Permanent Sticky Sidebar (Only on screens lg+) -->
        <div class="hidden lg:block lg:col-span-1 bg-white p-4 rounded-3xl border border-slate-200 shadow-xl space-y-1.5 h-fit sticky top-24">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2 pb-1 border-b border-slate-100 mb-2">{{ __('messages.guide_sections_nav') }}</p>

            {{-- 1. CORE GENERAL REGULATIONS SECTIONS --}}
            @foreach($generalSections as $i => $sec)
                <button
                    wire:click="setSection('{{ $sec->section_key }}')"
                    class="w-full text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-4 py-2.5 rounded-2xl text-xs font-black transition-all {{ ($activeSection === $sec->section_key && $activeSection !== 'skills_td') ? 'bg-[#0066FF] text-white shadow-md' : 'text-slate-700 hover:bg-slate-50 hover:text-[#0066FF]' }}"
                >
                    {{ ($i + 1) }}. {{ $sec->getLocalizedTitle() }}
                </button>
            @endforeach

            {{-- 2. GROUPED SKILLS & TECHNICAL DESCRIPTIONS CATEGORY (TD-01 to TD-64) --}}
            <div x-data="{ openTd: @json($activeSection === 'skills_td') }" class="pt-3 mt-3 border-t border-slate-100 space-y-2">
                <button
                    @click="openTd = !openTd; $wire.setSection('skills_td')"
                    class="w-full text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-4 py-3 rounded-2xl text-xs font-black transition-all flex items-center justify-between {{ $activeSection === 'skills_td' ? 'bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-md font-black' : 'bg-blue-50 text-[#0066FF] hover:bg-blue-100' }}"
                >
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 01-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'الدلائل التقنية للتخصصات (TD-01 à TD-64)' : (app()->getLocale() === 'en' ? 'Technical Descriptions (TD-01 to TD-64)' : 'الدلائل التقنية للتخصصات (TD-01 إلى TD-64)') }}</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="openTd ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="openTd" x-collapse class="mt-2 space-y-1.5 pr-2 max-h-80 overflow-y-auto">
                    <input type="text" wire:model.live.debounce.250ms="skillSearch" placeholder="{{ app()->getLocale() === 'fr' ? 'Rechercher un métier...' : 'بحث في التخصصات (اسم المهنة / الكود)...' }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium focus:ring-2 focus:ring-[#0066FF] mb-2" />
                    
                    @foreach($filteredSkillTds as $st)
                        <button
                            wire:click="setSkillTd('{{ $st->section_key }}')"
                            class="w-full text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-3 py-2 rounded-xl text-[11px] font-bold transition flex items-center justify-between {{ ($activeSection === 'skills_td' && $selectedSkillTd === $st->section_key) ? 'bg-[#0066FF] text-white shadow-sm font-black' : 'text-slate-700 hover:bg-slate-100 hover:text-[#0066FF]' }}"
                        >
                            <span class="truncate">{{ $st->getLocalizedTitle() }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- DYNAMIC CONTENT PANEL (DUAL SIDE-BY-SIDE VIEW: TEXT + PDF VIEWER TOGETHER) --}}
        <div class="lg:col-span-3 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl min-h-[700px]">
            @if($currentSection)
                <div class="space-y-6">
                    
                    {{-- Section Header Bar --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center">
                                @if($currentSection->icon_svg)
                                    <svg class="w-5 h-5 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $currentSection->icon_svg }}"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-[#06205C]">{{ $currentSection->getLocalizedTitle() }}</h2>
                                <p class="text-xs font-bold text-[#0066FF] mt-0.5">{{ app()->getLocale() === 'fr' ? 'Affichage Simultané: Texte analytique & PDF officiel' : (app()->getLocale() === 'en' ? 'Simultaneous View: Analytical Text & Official PDF' : 'عرض مزدوج مباشر: التحليل النصي والكراسة الرسمية PDF') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <button @click="currentPdfUrl = '{{ route('td.viewer', ['key' => $currentSection->section_key]) }}'; showPdfReader = true;" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-blue-50 hover:text-[#0066FF] text-slate-700 font-bold text-xs transition border border-slate-200 flex items-center gap-1.5 shadow-sm">
                                <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                <span>{{ app()->getLocale() === 'fr' ? 'Plein Écran PDF' : 'تكبير القارئ لملء الشاشة' }}</span>
                            </button>
                        </div>
                    </div>

                    {{-- DUAL SPLIT GRID: TEXT SUMMARY ON THE LEFT/RIGHT & EMBEDDED LIVE PDF VIEWER SIDE-BY-SIDE --}}
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        
                        {{-- PANEL 1: STRUCTURED TEXT ANALYSIS & DETAILS --}}
                        <div class="space-y-4 bg-slate-50/80 p-5 rounded-2xl border border-slate-200">
                            <div class="flex items-center gap-2 pb-2 border-b border-slate-200/80">
                                <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <h3 class="text-xs font-black text-[#06205C] uppercase tracking-wider">{{ app()->getLocale() === 'fr' ? 'Analyse Textuelle du Règlement' : (app()->getLocale() === 'en' ? 'Analytical Content Breakdown' : 'المحتوى النصي والتحليلي للبند') }}</h3>
                            </div>
                            
                            <div class="text-xs sm:text-sm text-slate-700 leading-relaxed space-y-3 max-h-[620px] overflow-y-auto pr-1">
                                {!! nl2br(e($currentSection->getLocalizedBody())) !!}
                            </div>

                            {{-- Additional Section-Specific Static Enrichments if needed --}}
                            @if($currentSection->section_key === 'overview')
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-slate-200">
                                    <div class="bg-blue-50 rounded-xl p-3 border border-blue-100 text-center">
                                        <p class="text-xl font-black text-[#0066FF]">+40</p>
                                        <p class="text-[10px] font-bold text-slate-600 mt-0.5">{{ __('messages.overview_skills_count') }}</p>
                                    </div>
                                    <div class="bg-emerald-50 rounded-xl p-3 border border-emerald-100 text-center">
                                        <p class="text-xl font-black text-emerald-600">2026</p>
                                        <p class="text-[10px] font-bold text-slate-600 mt-0.5">{{ __('messages.overview_year') }}</p>
                                    </div>
                                    <div class="bg-amber-50 rounded-xl p-3 border border-amber-100 text-center">
                                        <p class="text-base font-black text-amber-600">Oran</p>
                                        <p class="text-[10px] font-bold text-slate-600 mt-0.5">{{ __('messages.overview_venue') }}</p>
                                    </div>
                                </div>
                            @elseif($currentSection->section_key === 'accreditation')
                                <div class="overflow-x-auto pt-2">
                                    <table class="w-full text-[11px] rounded-xl overflow-hidden">
                                        <thead>
                                            <tr class="bg-[#0066FF] text-white">
                                                <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-3 py-2 font-black">{{ __('messages.acc_level') }}</th>
                                                <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-3 py-2 font-black">{{ __('messages.acc_beneficiaries') }}</th>
                                                <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-3 py-2 font-black">{{ __('messages.acc_access_scope') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach([
                                                ['badge'=>'A','color'=>'bg-[#0066FF]','title'=>'acc_a_title','who'=>'acc_a_who','access'=>'acc_a_access'],
                                                ['badge'=>'B','color'=>'bg-emerald-600','title'=>'acc_b_title','who'=>'acc_b_who','access'=>'acc_b_access'],
                                                ['badge'=>'C','color'=>'bg-amber-500','title'=>'acc_c_title','who'=>'acc_c_who','access'=>'acc_c_access'],
                                                ['badge'=>'D','color'=>'bg-purple-600','title'=>'acc_d_title','who'=>'acc_d_who','access'=>'acc_d_access'],
                                                ['badge'=>'E','color'=>'bg-slate-500','title'=>'acc_e_title','who'=>'acc_e_who','access'=>'acc_e_access'],
                                            ] as $i => $acc)
                                                <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-slate-50' }} border-b border-slate-100">
                                                    <td class="px-3 py-2">
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="w-5 h-5 rounded-md {{ $acc['color'] }} text-white text-[9px] font-black flex items-center justify-center">{{ $acc['badge'] }}</span>
                                                            <span class="font-black text-slate-700">{{ __('messages.' . $acc['title']) }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-2 text-slate-600">{{ __('messages.' . $acc['who']) }}</td>
                                                    <td class="px-3 py-2 text-slate-600">{{ __('messages.' . $acc['access']) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        {{-- PANEL 2: EMBEDDED LIVE PDF VIEWER (SIDE-BY-SIDE WITH TEXT) --}}
                        <div class="space-y-3 bg-slate-900 p-4 rounded-2xl border border-slate-800 shadow-2xl flex flex-col">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span class="text-xs font-black text-white">{{ app()->getLocale() === 'fr' ? 'Document PDF Officiel In-Platform' : (app()->getLocale() === 'en' ? 'Official In-Platform PDF Document' : 'المستند الرسمي المعتمد PDF (معاينة داخل المنصة)') }}</span>
                                </div>
                                <span class="text-[10px] font-bold text-amber-400 bg-amber-400/10 px-2 py-0.5 rounded border border-amber-400/20">PDF Live</span>
                            </div>
                            
                            <div class="flex-1 w-full min-h-[600px] rounded-xl overflow-hidden bg-white border border-slate-800">
                                <iframe src="{{ route('td.viewer', ['key' => $currentSection->section_key]) }}" class="w-full h-full min-h-[600px] border-0" title="PDF Document Viewer"></iframe>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- INLINE INTERACTIVE PDF / DOCUMENT READER MODAL --}}
    <div x-show="showPdfReader" 
         x-cloak 
         x-transition 
         class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-6 bg-slate-900/80 backdrop-blur-md">
        
        <div class="bg-white rounded-3xl w-full max-w-4xl h-[88vh] shadow-2xl border border-slate-200 flex flex-col overflow-hidden animate-in zoom-in duration-200">
            
            {{-- Modal Reader Header Bar --}}
            <div class="p-4 bg-[#06205C] text-white flex items-center justify-between gap-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#0066FF] text-white flex items-center justify-center shadow">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black">قارئ كراسة المواصفات التقنية الرسمية (Interactive Document Reader)</h3>
                        <p class="text-[11px] text-blue-200 mt-0.5">استعراض وتصفح الدليل دون الحاجة للتحميل أو الخروج من المنصة</p>
                    </div>
                </div>

                <button type="button" @click="showPdfReader = false" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center font-bold text-sm transition"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
            </div>

            {{-- Modal Document Content Area --}}
            <div class="flex-grow p-6 sm:p-8 overflow-y-auto bg-slate-50 space-y-6">
                @if($currentSection)
                    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                        <div class="pb-6 border-b border-slate-200">
                            <h2 class="text-xl sm:text-2xl font-black text-[#06205C]">{{ $currentSection->getLocalizedTitle() }}</h2>
                            <p class="text-xs font-bold text-slate-500 mt-1">WorldSkills International Shanghai 2026 — Approved Guide</p>
                        </div>

                        <div class="text-sm text-slate-800 leading-relaxed whitespace-pre-line prose max-w-none">
                            {!! nl2br(e($currentSection->getLocalizedBody())) !!}
                        </div>
                    </div>
                @endif
            </div>

            {{-- Footer Action Bar --}}
            <div class="p-4 bg-white border-t border-slate-200 flex items-center justify-between shrink-0">
                <p class="text-xs text-slate-500 font-bold">WorldSkills International Official Technical Standards 2026</p>
                <button type="button" @click="showPdfReader = false" class="px-6 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    إغلاق القارئ
                </button>
            </div>

        </div>
    </div>
</div>
