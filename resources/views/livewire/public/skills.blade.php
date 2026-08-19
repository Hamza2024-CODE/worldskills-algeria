@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };

$getSkillIcon = function($skill) {
    $catId = (int) $skill->category_id;
    return match($catId) {
        1 => 'cog',
        2 => 'cpu',
        3 => 'office-building',
        4 => 'truck',
        5 => 'sparkles',
        6 => 'user-group',
        default => 'cog',
    };
};

$getSkillImageUrl = function($skill) {
    return $skill ? $skill->getImageUrl() : 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=800&auto=format&fit=crop&q=80';
};
@endphp

<div class="py-12" x-data="{ showPdfModal: false, pdfUrl: '', pdfTitle: '' }" x-on:open-pdf-viewer.window="pdfUrl = $event.detail.pdfUrl || ($event.detail[0] ? $event.detail[0].pdfUrl : ''); pdfTitle = $event.detail.pdfTitle || ($event.detail[0] ? $event.detail[0].pdfTitle : ''); showPdfModal = true;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Hero Header with Glassmorphism Effect -->
        <div class="relative rounded-[36px] overflow-hidden bg-slate-950/80 backdrop-blur-xl text-white p-8 sm:p-14 shadow-2xl border border-white/20">
            {{-- Background Image Overlay --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/gallery_header_bg.png') }}" alt="Skills Header Background"
                     class="w-full h-full object-cover object-center opacity-35 transform scale-105 filter blur-xs">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-black/30"></div>
                <div class="absolute inset-0 bg-blue-950/30 mix-blend-overlay"></div>
            </div>

            {{-- Glassmorphism Glow Highlights --}}
            <div class="absolute -top-24 -end-24 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -start-24 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>

            {{-- Header Content --}}
            <div class="relative z-10 text-center max-w-3xl mx-auto space-y-5">
                <div class="inline-flex items-center gap-2.5 px-5 py-2 rounded-full bg-white/15 backdrop-blur-xl border border-white/30 text-white text-xs font-black uppercase tracking-wider shadow-lg">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 00-1.11.258l-1.012.607a2 2 0 00-.77 2.12l.74 2.96a2 2 0 001.94 1.515h13.224a2 2 0 001.94-1.515l.74-2.96a2 2 0 00-.77-2.12l-1.012-.607z"/>
                    </svg>
                    <span>{{ $t('دليل التخصصات والمهارات الرسمية', 'Guide des Métiers Officiels', 'Official Trade Skills & Occupations') }}</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-2xl">
                    {{ $t('تخصصات أولمبياد المهن', 'Métiers & Compétences Olympiques', 'Olympic Trade Skills & Occupations') }}
                </h1>
                <p class="text-xs sm:text-base text-slate-200 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-md">
                    {{ $t('استكشف جميع التخصصات الـ 64 المعتمدة مصنفة حسب القطاعات مع الصور التخصصية والكراسات التقنية.', 'Explorez les 64 métiers officiels classés par secteur avec photos spécialisées et descriptifs techniques.', 'Explore all 64 official competition skills categorized by sector with specialized trade photos and technical specifications.') }}
                </p>
            </div>
        </div>

        <!-- Filter & Search Controls (Glassmorphism Effect) -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[28px] p-6 shadow-xl border border-slate-200/90 space-y-5">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                
                {{-- Search Bar --}}
                <div class="relative w-full md:w-96">
                    <input type="text" wire:model.live.debounce.300ms="search"
                           placeholder="{{ $t('ابحث باسم المهنة أو الكود (مثال: SKILL-01)...', 'Rechercher un métier...', 'Search skill name or code...') }}"
                           class="w-full pr-11 pl-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-[#0066FF] shadow-inner">
                    <svg class="w-5 h-5 text-slate-400 absolute end-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                {{-- Category Filter Pills --}}
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <button type="button" wire:click="$set('selectedCategory', '')"
                            class="px-4 py-2.5 rounded-2xl text-xs font-black transition shadow-sm {{ $selectedCategory === '' ? 'bg-[#0066FF] text-white shadow-blue-500/30' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ $t('كافة القطاعات (64 مهنة)', 'Tous les secteurs', 'All Sectors (64 Skills)') }}
                    </button>
                    @foreach($categories as $cat)
                        <button type="button" wire:click="$set('selectedCategory', '{{ $cat->id }}')"
                                class="px-4 py-2.5 rounded-2xl text-xs font-bold transition {{ $selectedCategory == $cat->id ? 'bg-[#0066FF] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            {{ $cat->getLocalized('name') }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Skills Grid with Specialized Generated Photos & Sector Icons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($skills as $skill)
                @php
                    $imgUrl = $getSkillImageUrl($skill);
                    $iconType = $getSkillIcon($skill);
                @endphp
                <div class="bg-white/80 backdrop-blur-xl rounded-[28px] overflow-hidden border border-slate-200/90 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer flex flex-col justify-between hover:border-[#0066FF]">
                    
                    {{-- Skill High-Res Photo Header --}}
                    <div class="h-52 bg-slate-950 relative overflow-hidden">
                        <img src="{{ $imgUrl }}"
                             onerror="this.onerror=null; this.src='{{ asset('images/skills/manufacturing.png') }}';"
                             alt="{{ $skill->getLocalized('name') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-95">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-black/20 to-black/10 group-hover:opacity-90 transition-opacity"></div>

                        {{-- Code Badge (Top-Start) --}}
                        <div class="absolute top-4 start-4 px-3.5 py-1.5 rounded-full bg-[#0066FF] text-white font-mono font-black text-xs shadow-md border border-white/30">
                            {{ $skill->code }}
                        </div>

                        {{-- Sector Badge (Top-End) --}}
                        <div class="absolute top-4 end-4 px-3.5 py-1.5 rounded-full bg-black/75 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-wider border border-white/20">
                            {{ $skill->category ? $skill->category->getLocalized('name') : 'قطاع التكنولوجيا والمهن' }}
                        </div>

                        {{-- Skill Icon Overlay (Bottom-Start) --}}
                        <div class="absolute bottom-4 start-4 w-12 h-12 rounded-2xl bg-white/95 backdrop-blur-md text-[#0066FF] flex items-center justify-center shadow-lg border border-white">
                            @if($iconType === 'cpu')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M3 9h2m-2 6h2m14-6h2m-2 6h2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                            @elseif($iconType === 'office-building')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0V9m0 4h.01M15 9h.01M15 13h.01M11 13h.01M11 17h.01M15 17h.01"/></svg>
                            @elseif($iconType === 'truck')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8"/></svg>
                            @elseif($iconType === 'user-group')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            @elseif($iconType === 'sparkles')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            @endif
                        </div>
                    </div>

                    {{-- Card Details --}}
                    <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="text-lg font-black text-[#06205C] group-hover:text-[#0066FF] transition-colors leading-snug">
                                {{ $skill->getLocalized('name') }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-medium">
                                {{ $skill->getLocalized('description') }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                {{-- DETAILS BUTTON --}}
                                <button type="button" wire:click="openSkillDetails({{ $skill->id }})" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $t('عرض التفاصيل', 'Détails', 'Details') }}</span>
                                </button>

                                {{-- REVIEW PDF BUTTON --}}
                                @if($skill->getPdfUrl())
                                    <button type="button" 
                                            wire:click="openPdfViewer({{ $skill->id }})" 
                                            class="px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0066FF] border border-blue-200 font-black text-xs transition flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>PDF</span>
                                    </button>
                                @endif
                            </div>

                            <a href="{{ route('registration', ['skill_id' => $skill->id]) }}" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow transition flex items-center justify-center">
                                {{ $t('التسجيل بالمهنة', 'S\'inscrire', 'Register') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-16 text-center text-slate-400 bg-white rounded-3xl border border-slate-200 text-xs font-bold space-y-3">
                    <p>{{ $t('لا توجد تخصصات مطابقة لخيارات البحث.', 'Aucun métier correspondant.', 'No matching skills found.') }}</p>
                </div>
            @endforelse
        </div>

        <!-- Accessible Responsive Skill Details Modal -->
        @if($showModal && $selectedSkill)
            @php
                $modalImgUrl = $getSkillImageUrl($selectedSkill);
            @endphp
            <div x-data="{
                init() {
                    document.body.classList.add('overflow-hidden');
                },
                destroy() {
                    document.body.classList.remove('overflow-hidden');
                }
            }"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md transition-opacity">
                
                <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-6 relative max-h-[90vh] overflow-y-auto">
                    
                    <!-- Modal Header with Photo Banner -->
                    <div class="relative rounded-2xl overflow-hidden h-48 bg-slate-950 -mx-2 -mt-2">
                        <img src="{{ $modalImgUrl }}" 
                             onerror="this.onerror=null; this.src='{{ asset('images/skills/manufacturing.png') }}';"
                             alt="Skill Cover" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                        
                        <div class="absolute bottom-4 start-4 text-white space-y-1">
                            <span class="px-3 py-1 rounded-full bg-[#0066FF] font-mono font-black text-xs">
                                {{ $selectedSkill->code }}
                            </span>
                            <h2 class="text-xl sm:text-2xl font-black text-white drop-shadow">{{ $selectedSkill->getLocalized('name') }}</h2>
                        </div>

                        <button type="button" wire:click="closeSkillDetails" aria-label="Close Modal" class="absolute top-4 end-4 w-9 h-9 rounded-full bg-black/60 hover:bg-black text-white flex items-center justify-center font-bold transition">
                            ✕
                        </button>
                    </div>

                    <!-- Modal Details Grid -->
                    <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-slate-600 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold block mb-1">{{ $t('القطاع والفئة', 'Secteur & Catégorie', 'Sector & Category') }}</span>
                            <span class="font-bold text-[#06205C]">{{ $selectedSkill->category ? $selectedSkill->category->getLocalized('name') : $t('قطاع التكنولوجيا والمهن', 'Secteur Technologie & Métiers', 'Technology & Skills Sector') }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold block mb-1">{{ $t('شرط العمر المقبول', 'Âge Admissible', 'Eligible Age') }}</span>
                            <span class="font-bold text-emerald-600">{{ $selectedSkill->min_age ?? 16 }} {{ $t('إلى', 'à', 'to') }} {{ $selectedSkill->max_age ?? 22 }} {{ $t('سنة', 'ans', 'years') }}</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-black text-[#06205C] uppercase">{{ $t('الوصف الفني للمهنة:', 'Description Technique Officielle :', 'Official Technical Description:') }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            {{ $selectedSkill->getLocalized('description') }}
                        </p>
                    </div>

                    <!-- Skill Equipment Checklist -->
                    @if(count($selectedSkillEquipments) > 0)
                        <div class="space-y-3">
                            <h4 class="text-xs font-black text-[#06205C] uppercase">{{ $t('التجهيزات والأدوات الفنية المطلوبة:', 'Équipements et outils requis :', 'Required technical equipment & tools:') }}</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-700">
                                @foreach($selectedSkillEquipments as $eq)
                                    <div class="flex items-center gap-2 bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                                        <span class="w-2 h-2 rounded-full bg-[#0066FF]"></span>
                                        <span class="font-bold">{{ optional($eq->equipmentItem)->getLocalized('name') ?? $eq->getLocalized('name') ?? $t('تجهيزات ومعدات فنية', 'Équipement Technique', 'Technical Equipment') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Modal Actions -->
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <button type="button" wire:click="closeSkillDetails" class="px-4 py-3 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                                {{ $t('إغلاق', 'Fermer', 'Close') }}
                            </button>
                            @if($selectedSkill->getPdfUrl())
                                <button type="button" wire:click="openPdfViewer({{ $selectedSkill->id }})" class="px-4 py-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0066FF] border border-blue-200 text-xs font-black transition flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>{{ app()->getLocale() === 'fr' ? 'Consulter le PDF' : (app()->getLocale() === 'en' ? 'Review PDF Spec' : 'مراجعة الكراسة التقنية (PDF)') }}</span>
                                </button>
                            @endif
                        </div>

                        <a href="{{ route('registration', ['skill_id' => $selectedSkill->id]) }}" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white text-xs font-black shadow-lg transition flex items-center justify-center gap-2">
                            <span>{{ $t('التسجيل الفوري في هذه المهنة', 'S\'inscrire Immédiatement', 'Register Immediately') }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>

                </div>
            </div>
        @endif

    </div>

    {{-- INLINE INTERACTIVE PDF / DOCUMENT READER MODAL --}}
    <div x-show="showPdfModal" 
         x-cloak 
         x-transition 
         class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-6 bg-slate-900/80 backdrop-blur-md">
        
        <div class="bg-white rounded-3xl w-full max-w-5xl h-[92vh] shadow-2xl border border-slate-200 flex flex-col overflow-hidden animate-in zoom-in duration-200"
             x-data="{ activePdfTab: 'pdf' }">
            
            {{-- Modal Reader Header Bar --}}
            <div class="p-4 bg-[#06205C] text-white flex items-center justify-between gap-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#0066FF] text-white flex items-center justify-center shadow">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black flex items-center gap-2">
                            <span>قارئ ملف الـ PDF المباشر (Official PDF Technical Description)</span>
                        </h3>
                        <p class="text-[11px] text-blue-200 mt-0.5" x-text="pdfTitle || 'مراجعة ملف الكراسة الرسمية من داخل المنصة'"></p>
                    </div>
                </div>

                {{-- Tab Controls & Close --}}
                <div class="flex items-center gap-2">
                    <button type="button" @click="activePdfTab = 'pdf'" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5" :class="activePdfTab === 'pdf' ? 'bg-[#0066FF] text-white shadow' : 'bg-white/10 text-slate-300 hover:bg-white/20'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z"/></svg>
                        <span>ملف PDF الاصلي</span>
                    </button>

                    <button type="button" @click="activePdfTab = 'text'" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5" :class="activePdfTab === 'text' ? 'bg-[#0066FF] text-white shadow' : 'bg-white/10 text-slate-300 hover:bg-white/20'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        <span>النص التوصيفي</span>
                    </button>

                    <a :href="pdfUrl" target="_blank" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow" title="فتح الملف في نافذة جديدة">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span class="hidden sm:inline">فتح في نافذة جديدة ↗</span>
                    </a>

                    <button type="button" @click="showPdfModal = false" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center font-bold text-sm transition ms-2">
                        ✕
                    </button>
                </div>
            </div>

            {{-- Modal Document Content Area --}}
            <div class="flex-grow w-full bg-slate-100 relative overflow-hidden">
                
                {{-- TAB 1: NATIVE EMBEDDED PDF FILE --}}
                <div x-show="activePdfTab === 'pdf'" class="w-full h-full">
                    <template x-if="pdfUrl">
                        <object :data="pdfUrl + '#toolbar=1&navpanes=0&view=FitH'" type="application/pdf" class="w-full h-full">
                            <iframe :src="pdfUrl + '#toolbar=1'" class="w-full h-full border-none"></iframe>
                        </object>
                    </template>
                </div>

                {{-- TAB 2: TEXT SPECIFICATION SHEET --}}
                <div x-show="activePdfTab === 'text'" class="w-full h-full p-6 overflow-y-auto bg-slate-50 space-y-6">
                    @if($selectedSkill)
                        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                            <div class="pb-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <span class="px-3 py-1 rounded-full bg-blue-50 text-[#0066FF] font-mono font-black text-xs border border-blue-200 inline-block mb-2">
                                        {{ $selectedSkill->code }} — Official Technical Specification
                                    </span>
                                    <h2 class="text-xl sm:text-2xl font-black text-[#06205C]">{{ $selectedSkill->getLocalized('name') }}</h2>
                                    <p class="text-xs font-bold text-slate-500 mt-1">WorldSkills International Official Competition Standard</p>
                                </div>
                                @if($selectedSkill->category)
                                    <span class="px-3.5 py-1.5 rounded-full bg-purple-50 text-purple-700 font-bold text-xs border border-purple-200 self-start">
                                        {{ $selectedSkill->category->getLocalized('name') }}
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider">التفاصيل والتوصيف الفني المعتمد (Technical Description):</h3>
                                <div class="text-xs text-slate-800 leading-relaxed whitespace-pre-line bg-slate-50 p-5 rounded-2xl border border-slate-200 font-medium">
                                    @if($selectedGuideSection)
                                        {!! nl2br(e($selectedGuideSection->getLocalizedBody())) !!}
                                    @else
                                        {!! nl2br(e($selectedSkill->getLocalized('description'))) !!}
                                    @endif
                                </div>
                            </div>

                            {{-- Additional Skill Details in Text Tab --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100 text-xs">
                                <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 space-y-1">
                                    <span class="font-black text-[#0066FF] block">شروط الأعمار المقبولة</span>
                                    <span class="font-bold text-slate-700">{{ $selectedSkill->min_age ?? 16 }} إلى {{ $selectedSkill->max_age ?? 25 }} سنة</span>
                                </div>
                                <div class="bg-emerald-50/50 p-4 rounded-xl border border-emerald-100 space-y-1">
                                    <span class="font-black text-emerald-600 block">حالة التوصيف والمواصفات</span>
                                    <span class="font-bold text-slate-700">معتمد ورسمي (WorldSkills International Standard)</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white p-12 text-center text-slate-400 font-bold rounded-2xl border border-slate-200">
                            جاري تحميل النص التوصيفي للمهنة...
                        </div>
                    @endif
                </div>

            </div>

            {{-- Footer Action Bar --}}
            <div class="p-3.5 bg-white border-t border-slate-200 flex items-center justify-between shrink-0">
                <p class="text-xs text-slate-500 font-bold">WorldSkills International Official PDF Standard — Shanghai 2026</p>
                <button type="button" @click="showPdfModal = false" class="px-6 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    إغلاق المراجع
                </button>
            </div>

        </div>
    </div>
</div>
