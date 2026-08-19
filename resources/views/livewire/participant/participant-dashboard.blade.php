<div class="space-y-8" x-data="{ showBadgeModal: false }">
    @php
        $photoUrl = null;
        $authUser = auth()->user();
        $reg = $registration ?? null;
        $prof = $profile ?? null;

        if ($authUser && $authUser->avatar_path) {
            $photoUrl = $authUser->avatar_url;
        } elseif ($reg && $reg->photo_url && !str_contains($reg->photo_url, 'ui-avatars.com')) {
            $photoUrl = $reg->photo_url;
        } elseif ($prof && !empty($prof->photo_path)) {
            $photoUrl = asset('storage/' . ltrim($prof->photo_path, '/'));
        } elseif ($authUser) {
            $photoUrl = $authUser->avatar_url;
        }

        $locale = app()->getLocale();
        $candidateName = $authUser?->name;
        if ($prof) {
            if ($locale === 'ar' && !empty($prof->first_name_ar)) {
                $candidateName = trim($prof->first_name_ar . ' ' . $prof->last_name_ar);
            } elseif ($locale === 'fr' && !empty($prof->first_name_fr)) {
                $candidateName = trim($prof->first_name_fr . ' ' . $prof->last_name_fr);
            } elseif ($locale === 'en' && !empty($prof->first_name_en)) {
                $candidateName = trim($prof->first_name_en . ' ' . $prof->last_name_en);
            }
        }
        $suitSize = $editSuitSize ?? ($reg?->suit_size ?? 'L');
        $shoeSize = $editShoeSize ?? ($reg?->shoe_size ?? '43');
    @endphp

    @if(!empty($successMessage))
        <div class="p-4 rounded-2xl bg-emerald-500 text-white font-bold text-xs flex items-center justify-between shadow-lg animate-fade-in">
            <div class="flex items-center gap-2">
                <span>✓</span>
                <span>{{ $successMessage }}</span>
            </div>
            <button type="button" wire:click="$set('successMessage', '')" class="text-white/80 hover:text-white font-black text-sm">✕</button>
        </div>
    @endif

    <!-- Executive Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white p-6 sm:p-10 shadow-2xl border border-white/10">
        <!-- Subtle Decorative Elements -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-brand-sky/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="relative shrink-0">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-tr from-amber-400 via-brand-sky to-white p-1 shadow-xl overflow-hidden">
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $candidateName }}" class="w-full h-full rounded-[14px] object-cover border border-white/20">
                        @else
                            <div class="w-full h-full rounded-[14px] bg-[#06205C] flex items-center justify-center text-white font-black text-2xl sm:text-3xl border border-white/20">
                                {{ mb_substr($candidateName ?? 'م', 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-emerald-500 border-2 border-[#06205C] flex items-center justify-center text-[10px] text-white shadow-xs" title="حساب موثق">✓</span>
                </div>

                <div class="space-y-1.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-black tracking-wide flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Compétiteur Homologué' : (app()->getLocale() === 'en' ? 'Certified Competitor' : 'متنافس أولمبي معتمد') }}</span>
                        </span>
                        <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-slate-200 text-xs font-mono font-bold">
                            {{ $reg?->registration_number ?? 'WSAP-2026-DZ' }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        {{ $candidateName }}
                    </h1>
                    <p class="text-xs text-amber-200 font-bold">
                        {{ app()->getLocale() === 'fr' ? 'Bienvenue dans votre espace compétiteur officiel — WorldSkills Algeria' : (app()->getLocale() === 'en' ? 'Welcome to your official competitor dashboard — WorldSkills' : 'مرحباً بك في فضاء المتنافس الأولمبي — المنصة الوطنية الرسمية لأولمبياد المهن الجزائرية') }}
                    </p>
                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <p class="text-xs sm:text-sm text-blue-100/90 font-bold flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-sky shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Discipline: ' : (app()->getLocale() === 'en' ? 'Skill Trade: ' : 'التخصص التنافسي: ') }}</span>
                            <strong class="text-amber-300 font-extrabold">{{ $reg?->skill?->getLocalized('name') ?? 'التخصص الأولمبي الموحد' }}</strong>
                        </p>

                        <div class="flex items-center gap-2 sm:ps-3 border-s border-white/20">
                            <span class="px-2.5 py-0.5 rounded-lg bg-white/10 border border-white/20 text-xs font-mono font-bold text-amber-200" title="مقاس البدلة">
                                👔 {{ $suitSize }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-lg bg-white/10 border border-white/20 text-xs font-mono font-bold text-amber-200" title="مقاس الحذاء">
                                👟 {{ $shoeSize }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Pass Button -->
            <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                <button type="button" @click="showBadgeModal = true" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-amber-400 via-amber-500 to-amber-400 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-black text-xs shadow-xl shadow-amber-500/30 transition transform hover:scale-105 active:scale-95 flex items-center gap-2 border border-amber-300">
                    <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Afficher Badge Officiel' : (app()->getLocale() === 'en' ? 'View Official Badge' : 'بطاقة الاعتماد والشهادة') }}</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Official 5-Step Competition Milestone Journey (Responsive World-Class Olympic Stepper) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200/80 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#0066FF] animate-ping"></span>
                    <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                        {{ app()->getLocale() === 'fr' ? 'Parcours de Qualification et d\'Homologation' : (app()->getLocale() === 'en' ? 'Qualification & Accreditation Progress' : 'مسار التنافس والاعتماد الأولمبي الرسمي') }}
                    </h3>
                </div>
                <p class="text-xs text-slate-500 font-bold">
                    {{ app()->getLocale() === 'fr' ? 'Suivi précis des étapes de qualification et de préparation pour la compétition.' : (app()->getLocale() === 'en' ? 'Precise tracking of qualification and readiness milestones for the competition.' : 'متابعة دقيقة لمراحل التأهل والجاهزية للمشاركة في البطولة الوطنية والإفريقية.') }}
                </p>
            </div>
            <div class="px-4 py-1.5 rounded-full bg-gradient-to-r from-[#0066FF] to-[#00B8FF] text-white text-xs font-black shadow-md shadow-blue-500/20 self-start sm:self-auto flex items-center gap-1.5 shrink-0">
                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                <span>{{ app()->getLocale() === 'fr' ? 'Étape 3 sur 5' : (app()->getLocale() === 'en' ? 'Step 3 of 5' : 'المرحلة 3 من أصل 5') }}</span>
            </div>
        </div>

        <!-- Progress Bar & Responsive Steps -->
        <div class="space-y-4">
            <!-- Universal Horizontal Progress Indicator Line (Desktop) -->
            <div class="hidden lg:block relative w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-emerald-500 via-emerald-400 to-[#0066FF] rounded-full transition-all duration-1000 shadow-sm" style="width: 55%;"></div>
            </div>

            <!-- Responsive Steps Container (Flex Wrap on Tablet/Mobile, 5-Cols on Large Desktop) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                
                <!-- Step 1 (Completed) -->
                <div class="p-5 rounded-2xl bg-gradient-to-br from-emerald-500/10 via-emerald-50/40 to-white border border-emerald-300 space-y-3 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-emerald-400 text-white font-black text-xs flex items-center justify-center shadow-md shadow-emerald-500/20">✓</div>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-wider">
                            {{ app()->getLocale() === 'fr' ? 'Terminé' : (app()->getLocale() === 'en' ? 'Completed' : 'مكتمل') }}
                        </span>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-900 leading-tight">
                            {{ app()->getLocale() === 'fr' ? '① Soumission du dossier' : (app()->getLocale() === 'en' ? '① Application Submitted' : '① تقديم الطلب') }}
                        </h4>
                        <p class="text-[11px] text-slate-600 font-medium mt-1 leading-snug">
                            {{ app()->getLocale() === 'fr' ? 'Votre dossier a été reçu et enregistré.' : (app()->getLocale() === 'en' ? 'Your file has been received and registered.' : 'تم استقبال ملفك وتسجيله بالبوابة.') }}
                        </p>
                    </div>
                </div>

                <!-- Step 2 (Completed) -->
                <div class="p-5 rounded-2xl bg-gradient-to-br from-emerald-500/10 via-emerald-50/40 to-white border border-emerald-300 space-y-3 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-emerald-400 text-white font-black text-xs flex items-center justify-center shadow-md shadow-emerald-500/20">✓</div>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-wider">
                            {{ app()->getLocale() === 'fr' ? 'Terminé' : (app()->getLocale() === 'en' ? 'Completed' : 'مكتمل') }}
                        </span>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-900 leading-tight">
                            {{ app()->getLocale() === 'fr' ? '② Vérification Administrative' : (app()->getLocale() === 'en' ? '② Administrative Audit' : '② التدقيق الإداري') }}
                        </h4>
                        <p class="text-[11px] text-slate-600 font-medium mt-1 leading-snug">
                            {{ app()->getLocale() === 'fr' ? 'Vérification de l\'âge et des certificats.' : (app()->getLocale() === 'en' ? 'Verification of age and requirements.' : 'التحقق الإداري من شروط السن والشهادات.') }}
                        </p>
                    </div>
                </div>

                <!-- Step 3 (Current Active Step - Glowing) -->
                <div class="p-5 rounded-2xl bg-gradient-to-br from-blue-500/15 via-blue-50/60 to-white border-2 border-[#0066FF] space-y-3 shadow-xl shadow-blue-500/15 relative overflow-hidden transform scale-[1.02] transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-[#0066FF] to-[#00B8FF] text-white font-black text-xs flex items-center justify-center shadow-md shadow-blue-500/30 animate-pulse">3</div>
                        <span class="px-2.5 py-0.5 rounded-full bg-[#0066FF] text-white text-[10px] font-black uppercase tracking-wider shadow-xs flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Étape Actuelle' : (app()->getLocale() === 'en' ? 'Current Step' : 'المرحلة الحالية') }}</span>
                        </span>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-[#06205C] leading-tight">
                            {{ app()->getLocale() === 'fr' ? '③ Homologation & Équipement' : (app()->getLocale() === 'en' ? '③ Accreditation & Readiness' : '③ الاعتماد والجاهزية') }}
                        </h4>
                        <p class="text-[11px] text-slate-700 font-bold mt-1 leading-snug">
                            {{ app()->getLocale() === 'fr' ? 'Fourniture du costume et des équipements.' : (app()->getLocale() === 'en' ? 'Provision of workwear and equipment sizes.' : 'توفير بدلة العمل وقياس التجهيزات اللوجستية.') }}
                        </p>
                    </div>
                </div>

                <!-- Step 4 (Upcoming) -->
                <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200/80 space-y-3 opacity-80 hover:opacity-100 transition-opacity">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-600 font-black text-xs flex items-center justify-center">4</div>
                        <span class="px-2 py-0.5 rounded-full bg-slate-200/70 text-slate-500 text-[10px] font-bold">
                            {{ app()->getLocale() === 'fr' ? 'À venir' : (app()->getLocale() === 'en' ? 'Upcoming' : 'قادمة') }}
                        </span>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-700 leading-tight">
                            {{ app()->getLocale() === 'fr' ? '④ Épreuves & Compétition' : (app()->getLocale() === 'en' ? '④ Field Competition' : '④ المنافسة الميدانية') }}
                        </h4>
                        <p class="text-[11px] text-slate-500 font-medium mt-1 leading-snug">
                            {{ app()->getLocale() === 'fr' ? 'Lancement des épreuves et évaluation du jury.' : (app()->getLocale() === 'en' ? 'Start of trials and jury evaluation.' : 'انطلاق التنافس وتدقيق لجان التحكيم.') }}
                        </p>
                    </div>
                </div>

                <!-- Step 5 (Upcoming) -->
                <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200/80 space-y-3 opacity-80 hover:opacity-100 transition-opacity">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-600 font-black text-xs flex items-center justify-center">5</div>
                        <span class="px-2 py-0.5 rounded-full bg-slate-200/70 text-slate-500 text-[10px] font-bold">
                            {{ app()->getLocale() === 'fr' ? 'À venir' : (app()->getLocale() === 'en' ? 'Upcoming' : 'قادمة') }}
                        </span>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-700 leading-tight">
                            {{ app()->getLocale() === 'fr' ? '⑤ Certification & Cérémonie' : (app()->getLocale() === 'en' ? '⑤ Certification & Award' : '⑤ الشهادة والتتويج') }}
                        </h4>
                        <p class="text-[11px] text-slate-500 font-medium mt-1 leading-snug">
                            {{ app()->getLocale() === 'fr' ? 'Annonce des résultats et remises des médailles.' : (app()->getLocale() === 'en' ? 'Results announcement and official certificates.' : 'إعلان النتائج وتوثيق الشهادات الوطنية.') }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Official Competitor Information Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Skill Details Card -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4 hover:border-brand-300 transition group">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 rounded-2xl bg-brand-50 border border-brand-100 flex items-center justify-center text-brand-600 text-xl group-hover:scale-110 transition-transform font-black">
                    <svg class="w-6 h-6 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-mono font-bold">
                    {{ $reg?->skill?->code ?? 'SKILL-2026' }}
                </span>
            </div>

            <div class="space-y-1">
                <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">
                    {{ app()->getLocale() === 'fr' ? 'Discipline Olympique Assignée' : (app()->getLocale() === 'en' ? 'Assigned Competition Skill' : 'المهارة الأولمبية المسندة') }}
                </span>
                <h3 class="text-lg font-black text-slate-900 leading-snug">
                    {{ $reg?->skill?->getLocalized('name') ?? 'التخصص التنافسي الموحد' }}
                </h3>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-500">
                <span>{{ app()->getLocale() === 'fr' ? 'Métiers & Technologie' : (app()->getLocale() === 'en' ? 'Trades & Technology' : 'فئة المهن والتكنولوجيا') }}</span>
                <span class="text-brand-600 font-black">{{ app()->getLocale() === 'fr' ? 'Homologué Officiellement' : (app()->getLocale() === 'en' ? 'Officially Certified' : 'معتمد رسمياً') }}</span>
            </div>
        </div>

        <!-- Equipment & Uniform Size Card -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4 hover:border-amber-300 transition group relative">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 text-xl group-hover:scale-110 transition-transform font-black">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                </div>
                <button type="button" wire:click="$set('showSizeModal', true)" class="px-2.5 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-[11px] font-black transition flex items-center gap-1">
                    ✏️ <span>{{ app()->getLocale() === 'fr' ? 'Modifier' : (app()->getLocale() === 'en' ? 'Update Sizes' : 'تعديل المقاسات') }}</span>
                </button>
            </div>

            <div class="space-y-1">
                <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">
                    {{ app()->getLocale() === 'fr' ? 'Tailles des Équipements & Costume' : (app()->getLocale() === 'en' ? 'Workwear & Equipment Sizes' : 'مقاسات بدلة العمل والتجهيزات') }}
                </span>
                <h3 class="text-base font-black text-slate-900">
                    {{ app()->getLocale() === 'fr' ? 'Équipements de Sécurité & Protection (EPI)' : (app()->getLocale() === 'en' ? 'Safety & Field Protection Equipment (PPE)' : 'تجهيزات الأمن والسلامة الميدانية') }}
                </h3>
            </div>

            <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-3">
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-center">
                    <span class="text-[10px] font-bold text-slate-400 block mb-0.5">{{ app()->getLocale() === 'fr' ? 'Taille Costume' : (app()->getLocale() === 'en' ? 'Suit Size' : 'مقاس البدلة') }}</span>
                    <strong class="text-sm font-black text-slate-900">{{ $reg?->suit_size ?? ($profile?->suit_size ?? 'M') }}</strong>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-center">
                    <span class="text-[10px] font-bold text-slate-400 block mb-0.5">{{ app()->getLocale() === 'fr' ? 'Pointure Chaussures' : (app()->getLocale() === 'en' ? 'Shoe Size' : 'مقاس الحذاء') }}</span>
                    <strong class="text-sm font-black text-slate-900">{{ $reg?->shoe_size ?? ($profile?->shoe_size ?? '42') }}</strong>
                </div>
            </div>
        </div>

        <!-- Digital Pass & Verification Card -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4 hover:border-emerald-300 transition group">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 text-xl group-hover:scale-110 transition-transform font-black">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold">
                    {{ app()->getLocale() === 'fr' ? 'Code QR Sécurisé' : (app()->getLocale() === 'en' ? 'Secure QR Pass' : 'رمز الاستجابة السريع QR') }}
                </span>
            </div>

            <div class="space-y-1">
                <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">
                    {{ app()->getLocale() === 'fr' ? 'Badge d\'Accréditation & Pass' : (app()->getLocale() === 'en' ? 'Accreditation Pass & Badge' : 'بطاقة الاعتماد والشهادة') }}
                </span>
                <h3 class="text-base font-black text-slate-900">
                    {{ app()->getLocale() === 'fr' ? 'Authentification & Accréditation Numérique' : (app()->getLocale() === 'en' ? 'Digital Accreditation & Pass Verification' : 'التوثيق الرقمي والاعتماد الرسمي') }}
                </h3>
            </div>

            <div class="pt-3 border-t border-slate-100">
                <button type="button" @click="showBadgeModal = true" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-brand-600 text-white font-bold text-xs transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Vérifier Code d\'Accréditation' : (app()->getLocale() === 'en' ? 'Verify Accreditation Pass Code' : 'توثيق شفرة الاعتماد والشهادة') }}</span>
                </button>
            </div>
        </div>

    </div>

    <!-- ACCREDITATION BADGE & QR PASS MODAL -->
    <div x-show="showBadgeModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md" x-cloak>
        <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-6 shadow-2xl border border-slate-200 text-center relative overflow-hidden" @click.away="showBadgeModal = false">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <h3 class="text-sm font-black text-[#06205C]">
                        {{ app()->getLocale() === 'fr' ? 'Badge Officiel d\'Accréditation' : (app()->getLocale() === 'en' ? 'Official Accreditation Pass Badge' : 'بطاقة الاعتماد الأولمبية المباشرة') }}
                    </h3>
                </div>
                <button @click="showBadgeModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-sm">✕</button>
            </div>

            <!-- Official Badge Card Display -->
            <div class="bg-gradient-to-b from-[#06205C] to-[#020A24] rounded-3xl p-6 text-white space-y-4 shadow-xl border border-white/20 relative">
                
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full bg-amber-400 text-slate-950 text-[10px] font-black tracking-widest uppercase">
                        WORLDSKILLS ALGERIA
                    </span>
                    <span class="text-xs font-mono font-bold text-blue-200">
                        {{ $reg?->registration_number ?? 'WSAP-2026-DZ' }}
                    </span>
                </div>

                <!-- Competitor Photo & Name -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-24 h-24 rounded-2xl border-2 border-amber-400 overflow-hidden shadow-md bg-slate-800">
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $candidateName }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white font-black text-3xl bg-[#06205C]">
                                {{ mb_substr($candidateName ?? 'م', 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h4 class="text-lg font-black text-white">{{ $candidateName }}</h4>
                    <span class="text-xs text-amber-300 font-bold">{{ $reg?->skill?->getLocalized('name') ?? 'التخصص التنافسي الموحد' }}</span>
                </div>

                <!-- QR Code Representation -->
                <div class="bg-white p-3 rounded-2xl w-36 h-36 mx-auto flex items-center justify-center border-2 border-amber-400/50 shadow-inner">
                    @php
                        $qrTargetUrl = $reg 
                            ? route('official.certificate', ['identifier' => $reg->registration_number])
                            : route('home');
                    @endphp
                    <img src="{{ \App\Services\QrCodeService::generateDataUri($qrTargetUrl, 180) }}" alt="QR Accreditation Pass Code" class="w-full h-full object-contain">
                </div>

                <div class="space-y-1 text-center">
                    <p class="text-xs text-amber-200 font-bold">
                        {{ app()->getLocale() === 'fr' ? 'Pass QR d\'Accréditation Officiel' : (app()->getLocale() === 'en' ? 'Official Accreditation QR Pass' : 'شفرة التوثيق والاعتماد الأولمبي الرقمي') }}
                    </p>
                    <p class="text-[10px] text-slate-300 font-medium max-w-xs mx-auto leading-snug">
                        {{ app()->getLocale() === 'fr' 
                            ? 'Scannez ce code QR avec un smartphone pour vérifier l\'homologation du candidat en temps réel.' 
                            : (app()->getLocale() === 'en' 
                                ? 'Scan this QR code with any smartphone to verify candidate accreditation in real time.' 
                                : 'رمز التوثيق والاعتماد الأولمبي المشفر — يتيح للجان المنظمة والاستقبال المسح الفوري بالهاتف للتأكد من هوية المتنافس وتأهله.') }}
                    </p>
                    <p class="text-[10px] text-amber-300/80 font-mono pt-1">
                        Ref: {{ $reg?->registration_number ?? 'WSAP-2026-DZ' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-center gap-3 pt-2">
                <a href="{{ route('official.certificate', ['identifier' => $reg?->registration_number ?? 'WSAP-2026-DZ']) }}" target="_blank" class="px-5 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs transition shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Imprimer Badge & Certificat ↗' : (app()->getLocale() === 'en' ? 'Print Official Pass & Certificate ↗' : 'فتح وطباعة الشهادة الرسمية ↗') }}</span>
                </a>
                <button @click="showBadgeModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">
                    {{ app()->getLocale() === 'fr' ? 'Fermer' : (app()->getLocale() === 'en' ? 'Close' : 'إغلاق') }}
                </button>
            </div>
        </div>
    </div>

    <!-- EDIT SIZES MODAL -->
    @if(!empty($showSizeModal))
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-6 shadow-2xl border border-slate-200 text-right relative" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-[#06205C]">
                        {{ app()->getLocale() === 'fr' ? 'Modifier mes Équipements' : (app()->getLocale() === 'en' ? 'Update Official Equipment Sizes' : 'تعديل وتأكيد مقاسات بدلة العمل والتجهيزات') }}
                    </h3>
                    <button type="button" wire:click="$set('showSizeModal', false)" class="text-slate-400 hover:text-slate-600 font-bold text-sm">✕</button>
                </div>

                <form wire:submit.prevent="updateSizes" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ app()->getLocale() === 'fr' ? 'Taille du Costume Officiel *' : (app()->getLocale() === 'en' ? 'Official Suit Size *' : 'قياس البدلة الرسمية *') }}
                        </label>
                        <select wire:model="editSuitSize" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL', '3XL'] as $sz)
                                <option value="{{ $sz }}">{{ $sz }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ app()->getLocale() === 'fr' ? 'Pointure des Chaussures de Sécurité *' : (app()->getLocale() === 'en' ? 'Safety Shoes Size *' : 'قياس حذاء السلامة الميداني *') }}
                        </label>
                        <select wire:model="editShoeSize" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                            @foreach(range(36, 48) as $sh)
                                <option value="{{ $sh }}">{{ $sh }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ app()->getLocale() === 'fr' ? 'Taille / Hauteur (cm) *' : (app()->getLocale() === 'en' ? 'Height in cm *' : 'الطول بالسنتيمتر (سم) *') }}
                        </label>
                        <input type="number" wire:model="editHeightCm" min="140" max="210" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" wire:click="$set('showSizeModal', false)" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">
                            {{ app()->getLocale() === 'fr' ? 'Annuler' : (app()->getLocale() === 'en' ? 'Cancel' : 'إلغاء') }}
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow-md transition">
                            {{ app()->getLocale() === 'fr' ? 'Enregistrer les المقاسات' : (app()->getLocale() === 'en' ? 'Save Equipment Sizes' : 'حفظ وتأكيد المقاسات 💾') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
