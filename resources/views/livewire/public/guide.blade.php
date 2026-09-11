<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ app()->getLocale() === 'fr' ? 'Guide de Participation Olympiades 2026' : (app()->getLocale() === 'en' ? 'WorldSkills Algeria Participation Guide 2026' : 'دليل المشاركة الرسمي في أولمبياد المهن 2026') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Portail officiel pour comprendre les objectifs, conditions d\'éligibilité et règlements.' : (app()->getLocale() === 'en' ? 'Official portal to understand competition goals, eligibility and regulations.' : 'البوابة المعرفية الرسمية لفهم أهداف المسابقة، شروط المشاركة، وآليات التأهل والتنظيم.') }}
            </p>
        </div>

        <!-- Sections Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-lg hover:shadow-xl transition wsap-hover-card space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-500 flex items-center justify-center border border-brand-100 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Qu\'est-ce que WorldSkills ?' : (app()->getLocale() === 'en' ? 'What is WorldSkills?' : 'ما هو أولمبياد المهن؟') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Une compétition nationale et internationale visant à promouvoir les compétences professionnelles et l\'excellence.' : (app()->getLocale() === 'en' ? 'A national and international competition designed to promote vocational skills and excellence.' : 'مسابقة وطنية ودولية تهدف لتطوير وترقية مهارات التكوين والتعليم المهني، واكتشاف أصحاب الكفاءات العالية وتمثيل الجزائر دولياً.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-lg hover:shadow-xl transition wsap-hover-card space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-brand-sky flex items-center justify-center border border-sky-100 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-xl font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Conditions et Limite d\'Âge' : (app()->getLocale() === 'en' ? 'Eligibility & Age Limit' : 'شروط وسن المشاركة') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Ouvert aux jeunes talents âgés de 16 à 25 ans inscrits dans des établissements de formation.' : (app()->getLocale() === 'en' ? 'Open to young skilled talents aged 16 to 25 enrolled in training institutes.' : 'يتاح المشاركة لجميع المتربصين والشباب ذوي الكفاءة التقنية بين سن 16 و25 سنة، المسجلين بالمؤسسات الوطنية أو الوفود المشاركة.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-lg hover:shadow-xl transition wsap-hover-card space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-xl font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Normes de Sécurité & Équipements' : (app()->getLocale() === 'en' ? 'Safety Standards & Equipment' : 'معايير السلامة والتجهيز') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Conformité stricte aux équipements de protection individuelle (EPI) aux normes internationales.' : (app()->getLocale() === 'en' ? 'Strict compliance with personal protective equipment (PPE) international standards.' : 'تخضع المسابقة لشروط سلامة صارمة وارتداء معدات الحماية الشخصية (PPE) المطابقة للمواصفات الدولية لكل تخصص.') }}
                </p>
            </div>

        </div>
    </div>
</div>
