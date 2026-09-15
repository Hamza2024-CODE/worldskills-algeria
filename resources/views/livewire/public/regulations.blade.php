<div class="py-12" x-data="{ showPdfModal: false, currentPdfUrl: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">

            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ app()->getLocale() === 'fr' ? 'Règlements & Lois Officiels' : (app()->getLocale() === 'en' ? 'Official Regulations & Competition Rules' : 'اللوائح التنظيمية والقانونية للأولمبياد') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Consultez et téléchargez les règlements officiels régissant les Olympiades des Métiers.' : (app()->getLocale() === 'en' ? 'Review and download official regulations governing WorldSkills competitions.' : 'استعرض وحمّل كافة اللوائح الرسمية المنظمة لمسابقات أولمبياد المهن.') }}
            </p>
        </div>

        <!-- Downloads & Inline Previews List -->
        <div class="space-y-6 max-w-4xl mx-auto">
            
            <!-- Document 1: Reglement.pdf -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xl hover:shadow-2xl transition-all flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#0066FF] flex items-center justify-center border border-blue-200 font-black text-sm font-mono shadow-sm shrink-0">
                        PDF
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-[#06205C]">
                            {{ app()->getLocale() === 'fr' ? 'Règlement Général des Olympiades (Règlement Intérieur)' : (app()->getLocale() === 'en' ? 'General Competition Regulations & Internal Rules' : 'اللوائح العامة لمسابقات أولمبياد المهن (النظام الداخلي والقواعد)') }}
                        </h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            {{ app()->getLocale() === 'fr' ? 'Document Officiel WSI Standard — Version 1.0' : 'المستند التنظيمي الرسمي الشامل — شروط التنافس والتحكيم والتنظيم' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto shrink-0">
                    <button @click="currentPdfUrl = '{{ route('td.viewer', ['key' => 'rules']) }}'; showPdfModal = true;" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-[#0066FF] font-bold text-xs transition border border-slate-200 flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Consulter' : 'استعراض الآن' }}</span>
                    </button>

                    <a href="{{ asset('docs/Reglement.pdf') }}" download="Reglement-Officiel-WorldSkills.pdf" class="flex-1 md:flex-none px-5 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-extrabold text-xs shadow-md transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Télécharger PDF' : 'تحميل اللائحة PDF' }}</span>
                    </a>
                </div>
            </div>

            <!-- Document 2: GUIDE-PRATIQUE.pdf -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xl hover:shadow-2xl transition-all flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200 font-black text-sm font-mono shadow-sm shrink-0">
                        PDF
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-[#06205C]">
                            {{ app()->getLocale() === 'fr' ? 'Guide Pratique des Normes de Sécurité (PPE) & Épreuves' : (app()->getLocale() === 'en' ? 'Practical Safety & Equipment Standards Guide (PPE)' : 'دليل معايير السلامة والتجهيزات الشخصية (PPE) والدليل التطبيقي') }}
                        </h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            {{ app()->getLocale() === 'fr' ? 'Document Officiel WSI Standard — Version 2.1' : 'دليل السلامة والتأطير التقني المعتمد للأولمبياد' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto shrink-0">
                    <button @click="currentPdfUrl = '{{ route('td.viewer', ['key' => 'scoring']) }}'; showPdfModal = true;" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-amber-50 text-slate-700 hover:text-amber-700 font-bold text-xs transition border border-slate-200 flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Consulter' : 'استعراض الآن' }}</span>
                    </button>

                    <a href="{{ asset('docs/GUIDE-PRATIQUE.pdf') }}" download="Guide-Pratique-WorldSkills.pdf" class="flex-1 md:flex-none px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-md transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Télécharger PDF' : 'تحميل اللائحة PDF' }}</span>
                    </a>
                </div>
            </div>

            <!-- Document 3: Technical Descriptions TD-01 to TD-64 Link -->
            <div class="bg-gradient-to-r from-[#06205C] to-[#0066FF] rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="space-y-1">
                    <span class="px-3 py-0.5 rounded-full bg-amber-400 text-slate-950 font-black text-[10px] uppercase">
                        64 Technical Descriptions
                    </span>
                    <h3 class="text-base sm:text-lg font-black">
                        {{ app()->getLocale() === 'fr' ? 'Descriptions Techniques des 64 Métiers (TD-01 à TD-64)' : 'الكراسات والدلائل التقنية الخاصة بجميع التخصصات (TD-01 إلى TD-64)' }}
                    </h3>
                    <p class="text-xs text-blue-100">
                        {{ app()->getLocale() === 'fr' ? 'Consultez les cahiers des charges officiels de chaque métier en ligne.' : 'استعرض الكراسات التقنية التفصيلية لكل مهنة وتخصص مع القارئ المباشر.' }}
                    </p>
                </div>

                <a href="{{ route('guide.regulations') }}" class="w-full md:w-auto px-6 py-3 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs shadow-lg transition text-center shrink-0">
                    {{ app()->getLocale() === 'fr' ? 'Explorer les 64 Métiers' : 'الانتقال إلى دلائل التخصصات' }}
                </a>
            </div>

        </div>
    </div>

    <!-- IN-PLATFORM PDF READER MODAL -->
    <div x-show="showPdfModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-950/80 backdrop-blur-md">
        <div class="bg-slate-900 rounded-3xl w-full max-w-5xl h-[90vh] flex flex-col overflow-hidden border border-slate-800 shadow-2xl">
            <div class="p-4 bg-slate-950 text-white flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs font-black">{{ app()->getLocale() === 'fr' ? 'Lecteur PDF Officiel In-Platform' : 'قارئ المستندات المباشر — WorldSkills Algeria' }}</span>
                </div>
                <button @click="showPdfModal = false" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition">
                    إغلاق القارئ <x-ws.icon name="x-mark" class="w-4 h-4 inline-block ms-1" />
                </button>
            </div>
            <div class="flex-1 bg-white">
                <iframe :src="currentPdfUrl" class="w-full h-full border-0"></iframe>
            </div>
        </div>
    </div>
</div>
