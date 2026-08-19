<div class="py-12 bg-[#F4F7FC]" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white rounded-3xl p-8 sm:p-12 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-sky/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-black border border-white/20 inline-block">
                    🇩🇿 {{ app()->getLocale() === 'fr' ? 'Règlement d\'Utilisation Officiel' : (app()->getLocale() === 'en' ? 'Official Platform Governance' : 'اللائحة التنظيمية الرسمية') }}
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-white">
                    {{ app()->getLocale() === 'fr' ? 'Conditions Générales d\'Utilisation (CGU)' : (app()->getLocale() === 'en' ? 'Terms & Conditions of Service' : 'شروط وأحكام استخدام المنصة الوطنية') }}
                </h1>
                <p class="text-xs sm:text-sm text-blue-100 font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Règles et conditions régissant l\'accès au Portail Officiel WorldSkills Algeria 2026.' : (app()->getLocale() === 'en' ? 'Governance rules for accessing WorldSkills Algeria 2026 platform.' : 'القواعد والأحكام التنظيمية المقررة لاستخدام البوابة الرقمية لأولمبياد المهن الجزائرية 2026.') }}
                </p>
            </div>
        </div>

        <!-- Detailed Legal Body -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-md border border-slate-200/80 space-y-8 text-slate-800">
            
            <!-- Section 1: Accept Terms -->
            <div class="space-y-3">
                <h3 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>1. {{ app()->getLocale() === 'fr' ? 'Acceptation des Conditions' : (app()->getLocale() === 'en' ? 'Acceptance of Terms' : 'الموافقة والالتزام باللائحة') }}</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    إن الدخول إلى المنصة الوطنية الموحدة لأولمبياد المهن WorldSkills Algeria 2026 أو تسجيل الحسابات والمترشحين يعد موافقة صريحة وغير مشروطة على جميع الأحكام الواردة في هذه اللائحة، بالإضافة إلى الدليل واللوائح الفنية المعتمدة من وزارة التكوين والتعليم المهنيين.
                </p>
            </div>

            <hr class="border-slate-150">

            <!-- Section 2: Account Registration -->
            <div class="space-y-3">
                <h3 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>2. {{ app()->getLocale() === 'fr' ? 'Conditions d\'Éligibilité et Inscription' : (app()->getLocale() === 'en' ? 'Eligibility & Account Rules' : 'شروط التسجيل وصحة البيانات') }}</span>
                </h3>
                <ul class="list-disc list-inside text-xs sm:text-sm text-slate-600 leading-relaxed font-medium space-y-2">
                    <li>يلتزم المترشح والمؤسسة التكوينية بإدخال معلومات صحيحة ودقيقة ومطابقة للوثائق الرسمية.</li>
                    <li>يُمنع فتح حسابات وهمية أو استخدام هويات غير حقيقية، وتحتفظ إدارة المنصة بحق إلغاء الترشيح فوراً عند اكتشاف أي تزوير.</li>
                    <li>المستخدم مسؤول مسؤولية كاملة عن الحفاظ على سرية بيانات اعتماده وكلمة المرور الخاصة به.</li>
                </ul>
            </div>

            <hr class="border-slate-150">

            <!-- Section 3: Intellectual Property -->
            <div class="space-y-3">
                <h3 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>3. {{ app()->getLocale() === 'fr' ? 'Propriété Intellectuelle et Droits' : (app()->getLocale() === 'en' ? 'Intellectual Property Rights' : 'الملكية الفكرية والحقوق الرقمية') }}</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    جميع الشعارات، النماذج ثلاثية الأبعاد، التصاميم، الصور، العلامة التجارية، والوصف الفني للتخصصات المعروضة في المنصة هي ملك حصري للمؤسسة الوطنية لأولمبياد المهن والجهة الوصية. يُحظر استخدامها أو نسخها أو إعادة توزيعها دون ترخيص كتابي رسمي.
                </p>
            </div>

            <hr class="border-slate-150">

            <!-- Section 4: Platform Usage & Integrity -->
            <div class="space-y-3">
                <h3 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>4. {{ app()->getLocale() === 'fr' ? 'Sécurité et Utilisation Conforme' : (app()->getLocale() === 'en' ? 'Platform Security & Fair Use' : 'الاستخدام الآمن والنزاهة الرقمية') }}</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    يتعهد كل مستخدم بعدم اختراق المنصة، أو استخدام البرمجيات الخبيثة، أو محاولة تعطيل الخوادم وتطبيقات الاعتماد. تخضع جميع التحركات لسجلات التتبع والأمان الرقمي (Audit Logging).
                </p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4 text-xs font-bold text-slate-500">
                <span>تاريخ التحديث: 19 أغسطس 2026 — WorldSkills Algeria Governance</span>
                <a href="{{ route('regulations') }}" class="text-brand-600 hover:text-brand-700 underline">عرض اللائحة الفنية الكاملة للمنافسة</a>
            </div>
        </div>
    </div>
</div>
