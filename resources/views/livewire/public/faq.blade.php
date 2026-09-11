<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ app()->getLocale() === 'fr' ? 'Foire Aux Questions (FAQ)' : (app()->getLocale() === 'en' ? 'Frequently Asked Questions (FAQ)' : 'الأسئلة الشائعة وإجابات الاستفسارات المتكررة') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Réponses aux questions les plus fréquentes concernant les inscriptions et les règlements.' : (app()->getLocale() === 'en' ? 'Answers to the most frequent questions regarding registration, skills and rules.' : 'إليك إجابات لأهم الأسئلة المتعلقة بالتسجيل، التخصصات، والشروط.') }}
            </p>
        </div>

        <div class="max-w-4xl mx-auto space-y-4">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Qui peut s\'inscrire et participer aux Olympiades ?' : (app()->getLocale() === 'en' ? 'Who can register and participate in WorldSkills?' : 'من يمكنه التسجيل والمشاركة في أولمبياد المهن؟') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'L\'inscription est ouverte aux jeunes talents inscrits dans les établissements de formation ou délégations, âgés de 16 à 25 ans.' : (app()->getLocale() === 'en' ? 'Registration is open to young skilled candidates enrolled in vocational institutes or delegations, aged 16 to 25.' : 'يتاح التسجيل لجميع المتربصين والشباب المسجلين بمؤسسات التكوين والتعليم المهنيين أو الوفود الوطنية الشريكة، في الفئة العمرية بين 16 و25 سنة.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Quels sont les documents d\'identité requis (NIN / Passeport) ?' : (app()->getLocale() === 'en' ? 'What are the required ID documents (NIN / Passport)?' : 'ما هي الوثائق المطلوبة للمشارك الجزائري والمشارك الأجنبي؟') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Les candidats algériens doivent fournir le NIN à 18 chiffres. Les candidats internationaux doivent fournir un numéro de passeport valide.' : (app()->getLocale() === 'en' ? 'Algerian candidates provide an 18-digit National ID (NIN). International candidates provide a valid 18-digit Passport number.' : 'المشارك الجزائري يلتزم برقم بطاقة التعريف الوطنية (18 رقماً). أما المشارك الأجنبي فيلتزم بتقديم رقم جواز السفر الساري المفعول.') }}
                </p>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md hover:shadow-lg transition space-y-2">
                <h3 class="text-base font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Peut-on modifier la spécialité après soumission ?' : (app()->getLocale() === 'en' ? 'Can the skill discipline be changed after submission?' : 'هل يمكن تعديل التخصص بعد إرسال الطلب؟') }}
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Les données sont verrouillées après soumission. Toute modification nécessite l\'approbation de l\'administrateur de la délégation.' : (app()->getLocale() === 'en' ? 'Data is locked upon submission. Modifications require approval from the delegation administrator.' : 'يتم تجميد البيانات الحساسة بعد إرسال الطلب، ويمكن طلب إعادة الفتح عبر مسؤول الوفد أو Admin المنصة عند وجود مبرر مقبول.') }}
                </p>
            </div>
        </div>

    </div>
</div>
