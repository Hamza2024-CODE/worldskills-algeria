<div class="py-12 bg-[#F4F7FC]" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white rounded-3xl p-8 sm:p-12 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-sky/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-black border border-white/20 inline-block">
                    🇩🇿 {{ app()->getLocale() === 'fr' ? 'Conformité Légale Officielle' : (app()->getLocale() === 'en' ? 'Official Legal Compliance' : 'التنظيم القانوني الرسمي') }}
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-white">
                    {{ app()->getLocale() === 'fr' ? 'Politique de Confidentialité et Protection des Données' : (app()->getLocale() === 'en' ? 'Privacy Policy & Personal Data Protection' : 'سياسة الخصوصية وحماية المعطيات ذات الطابع الشخصي') }}
                </h1>
                <p class="text-xs sm:text-sm text-blue-100 font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Conforme à la Loi Algérienne N° 18-07 du 10 juin 2018 relative à la protection des personnes physiques dans le traitement des données à caractère personnel.' : (app()->getLocale() === 'en' ? 'In accordance with Algerian Law No. 18-07 of June 10, 2018 on the protection of individuals with regard to personal data processing.' : 'وفقاً لأحكام القانون الجزائري رقم 18-07 المؤرخ في 25 رمضان 1439 الموافق 10 يونيو 2018 المتعلق بحماية الأشخاص الطبيعيين في مجال معالجة المعطيات ذات الطابع الشخصي.') }}
                </p>
            </div>
        </div>

        <!-- Detailed Legal Body -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-md border border-slate-200/80 space-y-8 text-slate-800">
            
            <!-- Section 1: Introduction -->
            <div class="space-y-3">
                <h3 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>1. {{ app()->getLocale() === 'fr' ? 'Introduction et Champ d\'Application' : (app()->getLocale() === 'en' ? 'Introduction & Scope' : 'مقدمة ونطاق التطبيق') }}</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    تلتزم اللجنة الوطنية لأولمبياد المهن الجزائرية WorldSkills Algeria ووزارة التكوين والتعليم المهنيين بحماية الحرمة الشخصية وجميع المعطيات الرقمية الخاصة بالمترشحين، المحكّمين، أعضاء الوفود الوطنية، والزوار. تضمن هذه السياسة الشفافية والأمان التام لجميع البيانات المجموعة عبر المنصة الوطنية الموحدة 2026.
                </p>
            </div>

            <hr class="border-slate-150">

            <!-- Section 2: Collected Data -->
            <div class="space-y-3">
                <h3 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>2. {{ app()->getLocale() === 'fr' ? 'Données Collectées' : (app()->getLocale() === 'en' ? 'Collected Personal Data' : 'المعطيات ذات الطابع الشخصي المعالجة') }}</span>
                </h3>
                <ul class="list-disc list-inside text-xs sm:text-sm text-slate-600 leading-relaxed font-medium space-y-2">
                    <li><strong>بيانات الهوية والتسجيل:</strong> الاسم واللقب، تاريخ ومكان الميلاد، الرقم الوطني، والصورة الشخصية للاعتماد الفني.</li>
                    <li><strong>بيانات الاتصال والمؤسسة:</strong> البريد الإلكتروني الرسمي، رقم الهاتف، اسم مؤسسة التكوين المهني أو الولاية التابع لها المترشح.</li>
                    <li><strong>بيانات التخصص والتنافس:</strong> التخصص المهني المسجل به، التقييمات الفنية، والشهادات الصادرة.</li>
                    <li><strong>البيانات التقنية وتصفح الكوكيز:</strong> عنوان IP، تفضيلات اللغة، نوع الجهاز، وسجلات التسجيل لأغراض أمن المعلومات والتحقق الرقمي (QR Code).</li>
                </ul>
            </div>

            <hr class="border-slate-150">

            <!-- Section 3: Legal Basis & Purpose -->
            <div class="space-y-3">
                <h3 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>3. {{ app()->getLocale() === 'fr' ? 'Finalités et Base Légale' : (app()->getLocale() === 'en' ? 'Purposes of Data Processing' : 'أهداف المعالجة والأساس القانوني') }}</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    تستند معالجة المعطيات إلى المصلحة العامة والالتزام التنظيمي المسند لإدارة أولمبياد المهن، وتُستخدم حصرياً للأغراض التالية:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <h4 class="text-xs font-black text-[#06205C]">إدارة الاعتماد والتصفيات</h4>
                        <p class="text-[11px] text-slate-500">إصدار بطاقات التنافس الرقمية وسجلات النتائج الرسمية للمسابقة الوطنية.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <h4 class="text-xs font-black text-[#06205C]">تأمين الجلسات وتطبيقات الـ PWA</h4>
                        <p class="text-[11px] text-slate-500">التحقق الأمن المزدوج ومنع الازدواجية في التسجيل وتسجيل الدخول.</p>
                    </div>
                </div>
            </div>

            <hr class="border-slate-150">

            <!-- Section 4: Security & Rights -->
            <div class="space-y-3">
                <h3 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>4. {{ app()->getLocale() === 'fr' ? 'Sécurité et Droits de l\'Utilisateur' : (app()->getLocale() === 'en' ? 'Security & User Rights' : 'حماية البيانات وحقوق المعنيين') }}</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    طبقاً للقانون 18-07، يحق لكل مستخدم ومترشح الوصول إلى بياناته الشخصية، طلب تصحيحها، أو التعديل عليها عبر التواصل مع إدارة المنصة. تضمن المنصة التشفير التام لجميع البيانات المنقولة والمحفوظة (SSL/TLS Encryption & Secure Hash Storage).
                </p>
            </div>

            <hr class="border-slate-150">

            <!-- Section 5: Cookies & PWA -->
            <div class="space-y-3">
                <h3 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>5. {{ app()->getLocale() === 'fr' ? 'Cookies et Technologies PWA' : (app()->getLocale() === 'en' ? 'Cookies & PWA Offline Storage' : 'ملفات الكوكيز وتقنيات PWA') }}</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    تستخدم المنصة ملفات تعريف ارتباط مؤقتة لتخزين الجلسة وتأمين خيارات الخدمة وتسهيل عمل تطبيق الهاتف المحمول (PWA Offline Caching). يمكنك التحكم وتغيير إعدادات ملفات الكوكيز في أي وقت عبر زر التفضيلات السفلي للمنصة.
                </p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4 text-xs font-bold text-slate-500">
                <span>تاريخ التحديث الرسمي: 19 أغسطس 2026 — الإصدار V8.4</span>
                <a href="{{ route('contact') }}" class="text-brand-600 hover:text-brand-700 underline">التواصل مع مسؤول حماية البيانات (DPO)</a>
            </div>
        </div>
    </div>
</div>
