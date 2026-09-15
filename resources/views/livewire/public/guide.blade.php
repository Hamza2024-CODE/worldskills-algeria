<div class="py-12 bg-ws-bg min-h-screen" dir="{{ app()->getLocale() === "ar" ? "rtl" : "ltr" }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Header Hero Container (حاوية وكارت العنوان الرئيسي الفاخر) -->
        <div class="relative rounded-3xl sm:rounded-[36px] overflow-hidden bg-slate-950/85 backdrop-blur-2xl text-white p-8 sm:p-14 lg:p-16 shadow-2xl border border-white/20 text-center group">
            
            {{-- Background Image Overlay & Atmospheric Fog --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset("images/gallery_header_bg.png") }}" alt="Guide Header Background"
                     class="w-full h-full object-cover object-center opacity-30 transform scale-105 filter blur-xs pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/85 to-black/40"></div>
                <div class="absolute inset-0 bg-blue-950/30 mix-blend-overlay"></div>
            </div>

            {{-- Ambient Decorative Lighting Glows --}}
            <div class="absolute -top-24 -end-24 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl pointer-events-none group-hover:scale-110 transition-transform duration-1000"></div>
            <div class="absolute -bottom-24 -start-24 w-96 h-96 rounded-full bg-amber-500/15 blur-3xl pointer-events-none group-hover:scale-110 transition-transform duration-1000"></div>

            {{-- Center Content --}}
            <div class="relative z-10 max-w-3xl mx-auto space-y-5">
                
                {{-- Decorative Emblem Pod --}}
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center text-amber-300 mx-auto shadow-inner group-hover:scale-105 transition-transform duration-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>

                {{-- Main Title inside Container --}}
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-2xl">
                    {{ app()->getLocale() === "fr" ? "Guide de Participation Officiel — WorldSkills 2026" : (app()->getLocale() === "en" ? "Official WorldSkills Participation Guide 2026" : "دليل المشاركة الرسمي في أولمبياد المهن 2026") }}
                </h1>

                {{-- Subtitle / Description in Container --}}
                <p class="text-xs sm:text-base text-slate-200 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-md">
                    {{ app()->getLocale() === "fr" ? "Portail officiel pour comprendre les objectifs, conditions d'éligibilité, épreuves techniques et règlements de la compétition." : (app()->getLocale() === "en" ? "Official knowledge portal to understand competition goals, eligibility requirements, technical workflows, and regulations." : "البوابة المعرفية الرسمية لفهم أهداف المسابقة، شروط المشاركة، وآليات التأهل والتنظيم.") }}
                </p>

                {{-- Key Pillars / Indicators in Header --}}
                <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                    <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-slate-200 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>{{ app()->getLocale() === "fr" ? "Compétition Nationale & Internationale" : (app()->getLocale() === "en" ? "National & International Levels" : "منافسة وطنية ودولية رسمية") }}</span>
                    </div>
                    <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-slate-200 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        <span>{{ app()->getLocale() === "fr" ? "64 Métiers Homologués" : (app()->getLocale() === "en" ? "64 Approved Skills" : "64 تخصصاً ومهنة معتمدة") }}</span>
                    </div>
                    <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-slate-200 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                        <span>{{ app()->getLocale() === "fr" ? "Normes WorldSkills International" : (app()->getLocale() === "en" ? "WSI Standards" : "معايير WorldSkills الدولية") }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sections Grid (حاويات بطاقات المحتوى التوضيحية) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            
            {{-- Card 1: What is WorldSkills? --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 relative group overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0066FF] flex items-center justify-center border border-blue-100 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#06205C]">
                        {{ app()->getLocale() === "fr" ? "Qu'est-ce que WorldSkills Algeria ?" : (app()->getLocale() === "en" ? "What is WorldSkills Algeria?" : "ما هو أولمبياد المهن؟") }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        {{ app()->getLocale() === "fr" ? "La plus prestigieuse compétition nationale et internationale des métiers et compétences professionnelles réunissant les meilleurs talents de la formation professionnelle." : (app()->getLocale() === "en" ? "The premier national and international vocational skills competition showcasing top talents from technical and vocational training institutes." : "مسابقة وطنية ودولية تهدف لتطوير وترقية مهارات التكوين والتعليم المهني، واكتشاف أصحاب الكفاءات العالية وتمثيل الجزائر دولياً.") }}
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-black text-[#0066FF]">
                    <span>{{ app()->getLocale() === "fr" ? "Niveau Excellence" : (app()->getLocale() === "en" ? "Excellence Level" : "مستوى الامتياز الوطني") }}</span>
                    <span class="text-slate-400 font-mono text-[11px]">WSAP 2026</span>
                </div>
            </div>

            {{-- Card 2: Participation Eligibility --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 relative group overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#06205C]">
                        {{ app()->getLocale() === "fr" ? "Conditions et Âge de Participation" : (app()->getLocale() === "en" ? "Eligibility & Age Requirements" : "شروط وسن المشاركة") }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        {{ app()->getLocale() === "fr" ? "Ouvert aux apprentis, stagiaires et diplômés âgés de 16 à 25 ans inscrits dans des établissements de formation professionnelle agréés ou via les délégations nationales." : (app()->getLocale() === "en" ? "Open to apprentices, trainees, and graduates aged 16 to 25 registered in accredited vocational training centers or nominated delegations." : "يتاح المشاركة لجميع المتربصين والشباب ذوي الكفاءة التقنية بين سن 16 و25 سنة، المسجلين بالمؤسسات الوطنية أو الوفود المشاركة.") }}
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-black text-amber-600">
                    <a href="{{ route("registration") }}" class="hover:underline flex items-center gap-1">
                        <span>{{ app()->getLocale() === "fr" ? "Vérifier l'éligibilité" : (app()->getLocale() === "en" ? "Check Eligibility" : "التحقق والترشح") }}</span>
                        <span>→</span>
                    </a>
                    <span class="text-slate-400 font-mono text-[11px]">16 — 25 Ans</span>
                </div>
            </div>

            {{-- Card 3: Safety & PPE Standards --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 relative group overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#06205C]">
                        {{ app()->getLocale() === "fr" ? "Normes de Sécurité et Équipements (EPI)" : (app()->getLocale() === "en" ? "Safety & Equipment Standards (PPE)" : "معايير السلامة والتجهيز") }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        {{ app()->getLocale() === "fr" ? "Respect strict des consignes HSE, port obligatoire des Équipements de Protection Individuelle (EPI) homologués selon les fiches techniques de chaque métier." : (app()->getLocale() === "en" ? "Strict compliance with HSE safety protocols and mandatory certified Personal Protective Equipment (PPE) per trade specifications." : "تخضع المسابقة لشروط سلامة صارمة وارتداء معدات الحماية الشخصية (PPE) المطابقة للمواصفات الدولية لكل تخصص.") }}
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-black text-purple-600">
                    <a href="{{ route("regulations") }}" class="hover:underline flex items-center gap-1">
                        <span>{{ app()->getLocale() === "fr" ? "Fiches techniques" : (app()->getLocale() === "en" ? "Safety Specs" : "كراسات السلامة") }}</span>
                        <span>→</span>
                    </a>
                    <span class="text-slate-400 font-mono text-[11px]">HSE 100%</span>
                </div>
            </div>

            {{-- Card 4: Technical Stages & Trades --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 relative group overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#06205C]">
                        {{ app()->getLocale() === "fr" ? "64 Métiers et Épreuves Pratiques" : (app()->getLocale() === "en" ? "64 Skills & Practical Test Projects" : "نظام التصفيات ومراحل التأهل") }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        {{ app()->getLocale() === "fr" ? "Des épreuves intensives de 15 à 22 heures réparties sur 3 jours, conçues par des comités d'experts selon les standards internationaux." : (app()->getLocale() === "en" ? "Intensive 15 to 22-hour test projects over 3 days, designed by technical expert committees following international benchmarks." : "تمر المسابقة بتصفيات ولائية ثم جهوية وصولاً إلى النهائي الوطني في القرية الأولمبية بوهران للتنافس في مشاريع واقعية.") }}
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-black text-indigo-600">
                    <a href="{{ route("skills") }}" class="hover:underline flex items-center gap-1">
                        <span>{{ app()->getLocale() === "fr" ? "Explorer les métiers" : (app()->getLocale() === "en" ? "Explore Skills" : "استعراض التخصصات") }}</span>
                        <span>→</span>
                    </a>
                    <span class="text-slate-400 font-mono text-[11px]">64 Secteurs</span>
                </div>
            </div>

            {{-- Card 5: CIS Scoring System --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 relative group overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#06205C]">
                        {{ app()->getLocale() === "fr" ? "Système de Notation CIS (100 Points)" : (app()->getLocale() === "en" ? "CIS Scoring System (100 Points)" : "نظام التنقيط المعتمد CIS (100 نقطة)") }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        {{ app()->getLocale() === "fr" ? "La notation repose sur le système informatique CIS de WorldSkills avec une double vérification par les jurys et experts pour garantir une intégrité absolue." : (app()->getLocale() === "en" ? "Evaluation relies on the official WorldSkills CIS software with blind dual-scoring by juries to guarantee absolute integrity." : "يعتمد التقييم على منظومة CIS العالمية، ويتم احتساب الدرجات وفق معايير موضوعية وذاتية مدققة وموثقة إلكترونياً لضمان الشفافية والنزاهة المطلقة.") }}
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-black text-emerald-600">
                    <a href="{{ route("regulations") }}" class="hover:underline flex items-center gap-1">
                        <span>{{ app()->getLocale() === "fr" ? "Consulter le règlement" : (app()->getLocale() === "en" ? "View Regulations" : "اللوائح التنظيمية") }}</span>
                        <span>→</span>
                    </a>
                    <span class="text-slate-400 font-mono text-[11px]">100 Pts Base</span>
                </div>
            </div>

            {{-- Card 6: Official Registration & Accreditation --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 space-y-4 relative group overflow-hidden flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-[#06205C]">
                        {{ app()->getLocale() === "fr" ? "Accréditation & Badges Officiels" : (app()->getLocale() === "en" ? "Official Accreditation & Badges" : "الاعتماد والشارات الذكية") }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        {{ app()->getLocale() === "fr" ? "Chaque participant, juge et chef de délégation reçoit un badge d'accréditation officiel muni d'un QR code crypté pour l'accès aux zones et aux ateliers." : (app()->getLocale() === "en" ? "Each participant, jury member, and delegation head receives an official encrypted QR credential for workshop and venue access." : "يحصل كل متسابق ومحكّم ومسؤول وفد على شارة اعتماد رسمية مشفرة بـ QR Code تضمن حقه في الدخول، الإقامة، الإطعام، والمنافسة.") }}
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-black text-rose-600">
                    <a href="{{ route("registration") }}" class="hover:underline flex items-center gap-1">
                        <span>{{ app()->getLocale() === "fr" ? "S'inscrire maintenant" : (app()->getLocale() === "en" ? "Register Now" : "التسجيل في المسابقة") }}</span>
                        <span>→</span>
                    </a>
                    <span class="text-slate-400 font-mono text-[11px]">Encrypted QR</span>
                </div>
            </div>

        </div>

        <!-- Quick Access CTA Banner Container (حاوية الإجراء السريع في الأسفل) -->
        <div class="rounded-3xl bg-gradient-to-r from-[#0038A8] via-[#0066FF] to-[#00A3FF] text-white p-8 sm:p-10 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center {{ app()->getLocale() === "ar" ? "md:text-right" : "md:text-left" }}">
                <h3 class="text-xl sm:text-2xl font-black">
                    {{ app()->getLocale() === "fr" ? "Prêt à participer aux Olympiades WorldSkills 2026 ?" : (app()->getLocale() === "en" ? "Ready to compete in WorldSkills 2026?" : "جاهز للمشاركة في أولمبياد المهن 2026؟") }}
                </h3>
                <p class="text-xs text-blue-100 font-medium">
                    {{ app()->getLocale() === "fr" ? "Inscrivez-vous directement ou consultez le catalogue complet des compétences." : (app()->getLocale() === "en" ? "Register today or browse the complete trades and skills catalog." : "سجل ترشحك الآن أو تصفح الكتالوج الرسمي للتخصصات والكراسات التقنية.") }}
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0 flex-wrap justify-center">
                <a href="{{ route("skills") }}" class="px-6 py-3 rounded-2xl bg-white/15 hover:bg-white/25 backdrop-blur-md border border-white/30 text-white font-bold text-xs transition">
                    {{ app()->getLocale() === "fr" ? "Consulter les métiers" : (app()->getLocale() === "en" ? "Browse Skills" : "استعراض التخصصات") }}
                </a>
                <a href="{{ route("registration") }}" class="px-7 py-3 rounded-2xl bg-white hover:bg-blue-50 text-[#0052CC] font-black text-xs shadow-xl transition transform hover:-translate-y-0.5">
                    {{ __("messages.register_now") }}
                </a>
            </div>
        </div>

    </div>
</div>