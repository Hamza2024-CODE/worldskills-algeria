<div class="py-12 bg-[#F4F7FC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        @if(!$pagePartnersEnabled)
            <!-- Page Disabled Card -->
            <div class="max-w-xl mx-auto my-12 bg-white rounded-3xl p-8 sm:p-12 text-center space-y-6 shadow-xl border border-slate-200">
                <div class="w-16 h-16 rounded-3xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center mx-auto shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="space-y-2">
                    <h2 class="text-xl font-black text-[#06205C]">
                        {{ app()->getLocale() === 'fr' ? 'Page des Partenaires Indisponible' : (app()->getLocale() === 'en' ? 'Partners Page Currently Unavailable' : 'صفحة الشركاء غير متاحة حالياً بقرار تنظيمي') }}
                    </h2>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'Cette section a été désactivée temporairement par l\'administration.' : (app()->getLocale() === 'en' ? 'This section has been temporarily disabled by administration.' : 'تم إغلاق وتجميد عرض هذه الصفحة مؤقتاً بقرار من إدارة المنصة الرسمية.') }}
                    </p>
                </div>
                <a href="{{ route('home') }}" class="inline-block px-6 py-2.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md transition">
                    {{ app()->getLocale() === 'fr' ? 'Retour à l\'Accueil' : (app()->getLocale() === 'en' ? 'Return to Homepage' : 'العودة للرئيسية') }}
                </a>
            </div>
        @else
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors Officiels' : (app()->getLocale() === 'en' ? 'Official Partners & Sponsors' : 'الشركاء والجهات الراعية الرسمية') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Soutien institutionnel, industriel et technique pour le développement des compétences.' : (app()->getLocale() === 'en' ? 'Institutional, industrial and technical support for skill development.' : 'المؤسسات والهيئات الوطنية والشركاء الصناعيون الداعمون لتطوير الكفاءات الوطنية والتنافسية.') }}
            </p>
        </div>

        <!-- Animated Counters Overview for Partners -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <x-animated-counter :target="$stats['partners'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Partenaires Stratégiques' : (app()->getLocale() === 'en' ? 'Strategic Partners' : 'الشركاء الاستراتيجيون')" :description="app()->getLocale() === 'fr' ? 'Accords & Conventions' : (app()->getLocale() === 'en' ? 'Agreements & Alliances' : 'الاتفاقيات والشراكات الفنية')" image="/logo.svg" color="text-brand-500" />
            <x-animated-counter :target="$stats['organizations'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Établissements Partenaires' : (app()->getLocale() === 'en' ? 'Partner Institutes' : 'المؤسسات التدريبية')" :description="app()->getLocale() === 'fr' ? 'Centres d\'excellence' : (app()->getLocale() === 'en' ? 'Centers of Excellence' : 'مراكز التميز والتكوين')" color="text-brand-sky" />
            <x-animated-counter :target="$stats['skills'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Métiers Sponsorisés' : (app()->getLocale() === 'en' ? 'Sponsored Skills' : 'المهن المدعومة')" :description="app()->getLocale() === 'fr' ? 'Toutes disciplines' : (app()->getLocale() === 'en' ? 'All Skill Sectors' : 'كافة القطاعات والتخصصات')" color="text-purple-600" />
            <x-animated-counter :target="$stats['countries'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Pays Participants' : (app()->getLocale() === 'en' ? 'Participating Nations' : 'الدول المشاركة')" :description="app()->getLocale() === 'fr' ? 'Union Africaine' : (app()->getLocale() === 'en' ? 'African Union' : 'الاتحاد الإفريقي')" color="text-emerald-600" />
        </div>

        <!-- 1. FEATURED PARTNERS GRID -->
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <h2 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Partenaires Majeurs & Sponsors Stratégiques' : (app()->getLocale() === 'en' ? 'Major Partners & Strategic Sponsors' : 'الشركاء المميزون والرعاة الاستراتيجيون') }}</span>
                </h2>
                <span class="text-xs font-bold text-slate-400">{{ app()->getLocale() === 'fr' ? 'Mise à jour en temps réel' : (app()->getLocale() === 'en' ? 'Live Admin Sync' : 'تزامن مباشر مع لوحة الإدارة') }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredPartners as $p)
                    @php $logoUrl = $p->logo_path ? asset($p->logo_path) : null; @endphp
                    <div class="bg-white rounded-3xl p-8 text-center border border-slate-200/80 shadow-lg hover:shadow-xl transition flex flex-col justify-between space-y-6 group">
                        <div class="space-y-4">
                            <!-- Logo container -->
                            <div class="w-24 h-24 rounded-2xl bg-slate-50 p-4 border border-slate-100 flex items-center justify-center mx-auto shadow-sm group-hover:scale-105 transition-transform overflow-hidden">
                                @if($logoUrl)
                                    <img src="{{ $logoUrl }}" alt="{{ $p->getLocalized('name') }}" class="max-h-full max-w-full object-contain">
                                @else
                                    <span class="font-black text-xl text-blue-600 uppercase tracking-tight">{{ $p->getLocalized('name') }}</span>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-lg font-black text-[#06205C]">{{ $p->getLocalized('name') }}</h3>
                                @php
                                    $subName = match(app()->getLocale()) {
                                        'fr' => ($p->name_fr ? ($p->name_en ?: $p->name_ar) : null),
                                        'en' => ($p->name_en ? ($p->name_fr ?: $p->name_ar) : null),
                                        default => ($p->name_fr ?: $p->name_en)
                                    };
                                @endphp
                                @if($subName && $subName !== $p->getLocalized('name'))
                                    <p class="text-xs text-brand-500 font-bold font-mono">{{ $subName }}</p>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                {{ $p->getLocalized('description') ?: (
                                    app()->getLocale() === 'fr' 
                                        ? 'Partenaire officiel et contributeur stratégique aux Olympiades des Métiers Algérie 2026.' 
                                        : (app()->getLocale() === 'en' 
                                            ? 'Official partner and strategic contributor to WorldSkills Algeria 2026.' 
                                            : 'راعي رسمي ومساهم استراتيجي في منافسات أولمبياد المهن الجزائرية 2026.')
                                ) }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-400">
                            @php
                                $typeLabel = match(strtoupper($p->partner_type ?? '')) {
                                    'STRATEGIC' => app()->getLocale() === 'fr' ? 'STRATÉGIQUE' : (app()->getLocale() === 'en' ? 'STRATEGIC' : 'استراتيجي'),
                                    'OFFICIAL' => app()->getLocale() === 'fr' ? 'OFFICIEL' : (app()->getLocale() === 'en' ? 'OFFICIAL' : 'رسمي'),
                                    'INSTITUTIONAL' => app()->getLocale() === 'fr' ? 'INSTITUTIONNEL' : (app()->getLocale() === 'en' ? 'INSTITUTIONAL' : 'مؤسساتي'),
                                    'SPONSOR' => app()->getLocale() === 'fr' ? 'SPONSOR' : (app()->getLocale() === 'en' ? 'SPONSOR' : 'راعي'),
                                    'MEDIA' => app()->getLocale() === 'fr' ? 'MÉDIA' : (app()->getLocale() === 'en' ? 'MEDIA' : 'إعلامي'),
                                    'TECHNICAL' => app()->getLocale() === 'fr' ? 'TECHNIQUE' : (app()->getLocale() === 'en' ? 'TECHNICAL' : 'تقني'),
                                    default => $p->partner_type
                                };
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 font-mono text-[10px]">★ {{ $typeLabel }}</span>
                            @if($p->website_url)
                                <a href="{{ $p->website_url }}" target="_blank" class="text-blue-600 hover:underline font-mono text-[10px]">
                                    {{ app()->getLocale() === 'fr' ? 'Visiter le site →' : (app()->getLocale() === 'en' ? 'Visit Website →' : 'زيارة الموقع ←') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-400 font-medium bg-white rounded-3xl border border-slate-200">
                        {{ app()->getLocale() === 'fr' ? 'Aucun partenaire majeur pour le moment.' : (app()->getLocale() === 'en' ? 'No featured partners at the moment.' : 'لا يوجد شركاء مميزون حالياً.') }}
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. BANNER GRID MATCHING USER REFERENCE IMAGE -->
        <div class="space-y-4 pt-6">
            <div class="text-center">
                <h3 class="text-lg font-black text-[#06205C] tracking-wide">{{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors' : (app()->getLocale() === 'en' ? 'Partners & Sponsors' : 'الشركاء والرعاة') }}</h3>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-md p-6 sm:p-8 flex flex-wrap items-center justify-center gap-8 sm:gap-12">
                @forelse($allPartners as $p)
                    @php $logoUrl = $p->logo_path ? asset($p->logo_path) : null; @endphp
                    <div class="flex items-center justify-center transition transform hover:scale-110 cursor-pointer py-2 px-3">
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}" alt="{{ $p->name_ar }}" class="h-10 sm:h-12 w-auto object-contain filter grayscale hover:grayscale-0 transition duration-300">
                        @else
                            <span class="font-black text-lg sm:text-xl font-sans tracking-tight {{ match($loop->index % 5) {
                                0 => 'text-blue-600',
                                1 => 'text-slate-700',
                                2 => 'text-teal-600',
                                3 => 'text-amber-500',
                                default => 'text-rose-600'
                            } }}">
                                {{ $p->name_en ?: $p->name_ar }}
                            </span>
                        @endif
                    </div>
                @empty
                    <div class="text-xs text-slate-400 font-bold">{{ app()->getLocale() === 'fr' ? 'Aucun partenaire enregistré.' : (app()->getLocale() === 'en' ? 'No partners registered.' : 'لا يوجد شركاء مسجلين.') }}</div>
                @endforelse
            </div>
        </div>

        @endif
    </div>
</div>
