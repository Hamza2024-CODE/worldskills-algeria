<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ app()->getLocale() === 'fr' ? 'Calendrier Officiel des Olympiades 2026' : (app()->getLocale() === 'en' ? 'Official WorldSkills Schedule 2026' : 'جدول ومواعيد أولمبياد المهن 2026') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Suivez les étapes clés et le calendrier officiel des compétitions nationales et internationales.' : (app()->getLocale() === 'en' ? 'Track key milestones and official schedule of national and international competitions.' : 'تتبع المواعيد الزمنية الدقيقة لكل مرحلة من مراحل المنافسة الوطنية والدولية.') }}
            </p>
        </div>

        <!-- Timeline Items -->
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-brand-500 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="px-3 py-1 rounded-xl bg-brand-50 text-brand-500 font-extrabold text-[11px] border border-brand-200">
                        {{ app()->getLocale() === 'fr' ? 'Étape 01' : (app()->getLocale() === 'en' ? 'Phase 01' : 'المرحلة 01') }}
                    </span>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ app()->getLocale() === 'fr' ? 'Sélections dans les Établissements de Formation' : (app()->getLocale() === 'en' ? 'Selection at Training Institutes Level' : 'الاختيارات على مستوى المؤسسات التكوينية') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Tous les centres de formation professionnelle à travers le pays.' : (app()->getLocale() === 'en' ? 'All vocational training centers across the nation.' : 'جميع مؤسسات التكوين والتعليم المهنيين عبر الوطن') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#06205C] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    02 Mars - 02 Avril 2026
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-brand-sky border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="px-3 py-1 rounded-xl bg-sky-50 text-brand-sky font-extrabold text-[11px] border border-sky-200">
                        {{ app()->getLocale() === 'fr' ? 'Étape 02' : (app()->getLocale() === 'en' ? 'Phase 02' : 'المرحلة 02') }}
                    </span>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ app()->getLocale() === 'fr' ? 'Compétitions Wilayales (58 Wilayas)' : (app()->getLocale() === 'en' ? 'Regional Competitions (58 Wilayas)' : 'المسابقات الولائية (58 ولاية)') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Espaces et complexes régionaux dans chaque wilaya.' : (app()->getLocale() === 'en' ? 'Regional centers and exhibition halls in every province.' : 'الأماكن العامة والفضاءات الكبرى بكل ولاية') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#06205C] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    20 - 24 Avril 2026
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-purple-500 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="px-3 py-1 rounded-xl bg-purple-50 text-purple-600 font-extrabold text-[11px] border border-purple-200">
                        {{ app()->getLocale() === 'fr' ? 'Étape 03' : (app()->getLocale() === 'en' ? 'Phase 03' : 'المرحلة 03') }}
                    </span>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ app()->getLocale() === 'fr' ? 'Compétitions Inter-Régionales (5 Pôles)' : (app()->getLocale() === 'en' ? 'Zonal Championship (5 Hubs)' : 'المسابقات الجهوية (5 أقطاب)') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Alger, Constantine, Oran, Ghardaïa, Béchar' : (app()->getLocale() === 'en' ? 'Algiers, Constantine, Oran, Ghardaia, Bechar' : 'الجزائر، قسنطينة، وهران، غرداية، بشار') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#06205C] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    21 - 25 Septembre 2026
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-emerald-500 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="px-3 py-1 rounded-xl bg-emerald-50 text-emerald-600 font-extrabold text-[11px] border border-emerald-200">
                        {{ app()->getLocale() === 'fr' ? 'Étape 04' : (app()->getLocale() === 'en' ? 'Phase 04' : 'المرحلة 04') }}
                    </span>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ app()->getLocale() === 'fr' ? 'Finale Nationale & Couronnement' : (app()->getLocale() === 'en' ? 'National Finals & Award Ceremony' : 'النهائيات الوطنية وتتويج الفائزين') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Palais des Expositions & Complexe Olympique' : (app()->getLocale() === 'en' ? 'Exhibition Center & Olympic Hall' : 'المركب الرياضي والتنافسي - الجزائر العاصمة') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#06205C] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    16 - 21 Novembre 2026
                </div>
            </div>
        </div>
    </div>
</div>
