<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ app()->getLocale() === 'fr' ? 'Résultats Officiels & Classement' : (app()->getLocale() === 'en' ? 'Official Results & Rankings' : 'نتائج وتأهيلات أولمبياد المهن') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Consultez les listes des qualifiés et médaillés par discipline et par étape.' : (app()->getLocale() === 'en' ? 'View qualified candidates and medal winners across skill disciplines.' : 'استعرض قوائم المتأهلين والميداليات عبر مختلف المراحل والتخصصات.') }}
            </p>
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-[11px] font-bold shadow-2xs">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Système d\'évaluation WSAP — 100 points, basé sur la méthodologie WorldSkills International.' : (app()->getLocale() === 'en' ? 'WSAP Evaluation System — 100 points, based on WorldSkills International methodology.' : 'نظام تقييم WSAP — 100 نقطة، مبني على منهجية WorldSkills International والمعايير المعتمدة لكل مهنة.') }}</span>
            </div>
        </div>

        <!-- Announcement Card -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 text-center max-w-2xl mx-auto border border-slate-200/80 shadow-xl space-y-6">
            <div class="w-16 h-16 rounded-full bg-brand-50 text-brand-500 flex items-center justify-center mx-auto border border-brand-100 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="space-y-2">
                <h3 class="text-xl font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Les résultats 2026 seront publiés dès validation' : (app()->getLocale() === 'en' ? '2026 Results Will Be Published Upon Certification' : 'نتائج الدورة الوطنية 2026 ستنشر فور الكشف عنها') }}
                </h3>
                <p class="text-xs text-slate-500 font-medium leading-relaxed">
                    {{ app()->getLocale() === 'fr' ? 'Les résultats officiels des sélections seront proclamés progressivement selon le calendrier.' : (app()->getLocale() === 'en' ? 'Official qualification lists will be announced gradually according to schedule.' : 'سيتم إعلان النتائج الرسمية للمرحلة المؤسساتية والولائية تباعاً وفق الرزنامة المعروضة.') }}
                </p>
            </div>
            <div class="pt-4 border-t border-slate-100">
                <a href="https://worldskills.dz/wp-content/uploads/2025/11/Liste-WSA-Participent-.pdf" target="_blank" class="px-8 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-black text-xs shadow-lg transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Télécharger la liste préliminaire' : (app()->getLocale() === 'en' ? 'Download Preliminary List' : 'تحميل القائمة الأولية للمشاركين PDF') }}</span>
                </a>
            </div>
        </div>

    </div>
</div>
