<div class="min-h-screen py-8 px-4 bg-slate-100 font-sans print:bg-white print:py-0 print:px-0">
    
    {{-- A4 PVC Multi-Badge Print CSS Engine --}}
    <style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 10mm !important;
        }
        html, body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        nav, header, footer, .print\:hidden {
            display: none !important;
            visibility: hidden !important;
        }
        .badge-print-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 15mm !important;
            page-break-inside: auto !important;
        }
        .badge-item-print {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            margin: 0 auto !important;
        }
    }

    .card-body-3d-print {
        width: 320px;
        height: 520px;
        border-radius: 30px;
        position: relative;
        background: var(--theme-card-bg, linear-gradient(145deg, #06205C 0%, #01091C 100%));
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        z-index: 10;
        box-sizing: border-box;
    }
    .lanyard-hole-3d-print {
        width: 55px;
        height: 14px;
        background: #ffffff;
        border-radius: 10px;
        margin-top: 2px;
        border: 2px solid #cbd5e1;
    }
    .text-embroidered-white-print {
        color: #FFFFFF;
        text-shadow: 0px 1px 2px rgba(0,0,0,0.8);
    }
    .text-embroidered-accent-print {
        color: var(--theme-text-accent, #87CEEB);
    }
    </style>

    <!-- Top Action Bar (Hidden when printing) -->
    <div class="max-w-6xl mx-auto mb-8 bg-white border border-slate-200 p-6 rounded-3xl shadow-xl space-y-4 print:hidden" dir="rtl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <h1 class="text-xl font-black text-[#06205C]">
                    🖨️ {{ app()->getLocale() === 'fr' ? 'Impression Groupée des Badges' : (app()->getLocale() === 'en' ? 'Bulk PVC Badges Printing' : 'الطباعة الجماعية لبطاقات الاعتماد الرسمية') }}
                </h1>
                <p class="text-xs text-slate-500 font-bold mt-1">
                    {{ count($badgeItems) }} {{ app()->getLocale() === 'fr' ? 'badges générés prêts à l\'impression.' : (app()->getLocale() === 'en' ? 'generated PVC badges ready for batch printing.' : 'بطاقة اعتماد شارة جاهزة للطباعة الجماعية المباشرة.') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.accreditations.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition">
                    ← {{ app()->getLocale() === 'fr' ? 'Retour' : (app()->getLocale() === 'en' ? 'Back' : 'الرجوع لمركز الاعتماد') }}
                </a>
                <button type="button" onclick="window.print()" class="px-6 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-black text-xs shadow-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Lancer l\'Impression Groupée (Print All)' : (app()->getLocale() === 'en' ? 'Print All Badges' : 'طـبـاعة جميع البطاقات الآن 🖨️') }}</span>
                </button>
            </div>
        </div>

        <!-- Filter Selector inside Bulk Print Page -->
        <form method="GET" action="{{ route('admin.accreditations.bulk-print') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    {{ app()->getLocale() === 'fr' ? 'Filtrer par Rôle / Catégorie' : (app()->getLocale() === 'en' ? 'Filter by Category / Role' : 'تصفية حسب الصفة / الفئة المقبولة') }}
                </label>
                <select name="role" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                    <option value="ALL" {{ $filterRole === 'ALL' ? 'selected' : '' }}>-- {{ app()->getLocale() === 'fr' ? 'Toutes les catégories' : (app()->getLocale() === 'en' ? 'All Roles' : 'جميع الفئات والصفات') }} --</option>
                    <option value="COMPETITOR" {{ $filterRole === 'COMPETITOR' ? 'selected' : '' }}>المتنافسون (Competitors)</option>
                    <option value="EXPERT JUDGE" {{ $filterRole === 'EXPERT JUDGE' ? 'selected' : '' }}>الحكام والخبراء (Expert Judges)</option>
                    <option value="DELEGATION HEAD" {{ $filterRole === 'DELEGATION HEAD' ? 'selected' : '' }}>رؤساء الوفود (Delegation Heads)</option>
                    <option value="MEDIA" {{ $filterRole === 'MEDIA' ? 'selected' : '' }}>الوفد الإعلامي (Press / Media)</option>
                    <option value="ORGANIZER" {{ $filterRole === 'ORGANIZER' ? 'selected' : '' }}>المنظمون (Organizers)</option>
                    <option value="VIP" {{ $filterRole === 'VIP' ? 'selected' : '' }}>المراقبون والوزراء (VIP Observers)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    {{ app()->getLocale() === 'fr' ? 'Filtrer par Pays' : (app()->getLocale() === 'en' ? 'Filter by Country' : 'تصفية حسب الدولة') }}
                </label>
                <select name="country" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                    <option value="">-- {{ app()->getLocale() === 'fr' ? 'Tous les pays' : (app()->getLocale() === 'en' ? 'All Countries' : 'جميع الدول المشاركة') }} --</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}" {{ (string)$filterCountry === (string)$c->id ? 'selected' : '' }}>{{ $c->name_ar }} ({{ $c->name_fr }})</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                    {{ app()->getLocale() === 'fr' ? 'Appliquer Filtres' : (app()->getLocale() === 'en' ? 'Apply Filters' : 'تحديث القائمة 🔄') }}
                </button>
            </div>
        </form>
    </div>

    <!-- BULK BADGES PRINT GRID (2 BADGES PER ROW ON A4) -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 badge-print-grid">
        @forelse($badgeItems as $item)
            @php
                $roleKey = strtoupper($item['roleTitle']);
                $theme = match($roleKey) {
                    'SPEAKER' => ['card_bg' => 'linear-gradient(145deg, #4C1D95 0%, #1E0235 100%)', 'text_accent' => '#E9D5FF', 'badge' => 'محاضر رئيسي — SPEAKER'],
                    'MINISTERIAL EXECUTIVE OBSERVER' => ['card_bg' => 'linear-gradient(145deg, #311B92 0%, #0D0536 100%)', 'text_accent' => '#FFD700', 'badge' => 'وزير / مراقب تنفيذي — OBSERVER'],
                    'DELEGATION HEAD' => ['card_bg' => 'linear-gradient(145deg, #023E28 0%, #011F14 100%)', 'text_accent' => '#F3E5AB', 'badge' => 'مسؤول الوفد — DELEGATION HEAD'],
                    'VIP' => ['card_bg' => 'linear-gradient(145deg, #023E28 0%, #011F14 100%)', 'text_accent' => '#F3E5AB', 'badge' => 'عضو دبلوماسي — VIP DIPLOMATIC'],
                    'EXPERT JUDGE' => ['card_bg' => 'linear-gradient(145deg, #1E1B4B 0%, #0B1021 100%)', 'text_accent' => '#87CEEB', 'badge' => 'خبير محكّم — EXPERT JUDGE'],
                    'MEDIA' => ['card_bg' => 'linear-gradient(145deg, #78350F 0%, #240C02 100%)', 'text_accent' => '#FDE68A', 'badge' => 'وفد إعلامي — MEDIA / PRESS'],
                    'ORGANIZER' => ['card_bg' => 'linear-gradient(145deg, #1E293B 0%, #0F172A 100%)', 'text_accent' => '#CBD5E1', 'badge' => 'منظم رسمي — ORGANIZER'],
                    default => ['card_bg' => 'linear-gradient(145deg, #06205C 0%, #01091C 100%)', 'text_accent' => '#BAE6FD', 'badge' => 'متنافس رسمي — COMPETITOR'],
                };
            @endphp

            <div class="badge-item-print card-body-3d-print" style="--theme-card-bg: {{ $theme['card_bg'] }}; --theme-text-accent: {{ $theme['text_accent'] }};">
                <div class="lanyard-hole-3d-print"></div>

                <div class="relative z-20 w-full flex flex-col flex-grow justify-between mt-2 overflow-hidden text-center">
                    <div class="w-full flex justify-center items-center pt-1 pb-1">
                        <img src="/LOGO01.png" alt="Emblem" class="h-20 w-auto max-w-[90%] object-contain filter drop-shadow-md">
                    </div>

                    <div class="w-full flex justify-center items-center my-1 z-30">
                        <div class="relative w-[180px] h-[180px] bg-white rounded-2xl p-2 flex flex-col items-center justify-between border border-slate-200 shadow-md">
                            <div class="w-[145px] h-[145px] flex items-center justify-center bg-white rounded-lg">
                                <img src="{{ $item['qrCodeUrl'] }}" alt="QR Code" class="w-full h-full object-contain">
                            </div>
                            <div class="text-[7px] font-mono font-black text-slate-500 uppercase tracking-wider">WSAP ZERO-TRUST</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between w-full px-2 mt-1 gap-2">
                        <div class="text-right flex-1 min-w-0">
                            <h2 class="text-white text-sm font-extrabold truncate">{{ $item['nameAr'] }}</h2>
                            <div class="text-xs font-mono font-bold text-slate-300 truncate" dir="ltr">{{ $item['nameLatin'] }}</div>
                        </div>
                        <div class="shrink-0" dir="ltr">
                            <img src="/logo.svg" alt="WorldSkills" class="h-8 w-auto filter brightness-0 invert">
                        </div>
                    </div>

                    <div class="w-full text-center mt-2 mb-1">
                        <h3 class="text-white text-xs font-black tracking-wide uppercase truncate" dir="ltr">{{ $theme['badge'] }}</h3>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 bg-white rounded-3xl text-center text-slate-400 font-bold text-sm border border-slate-200">
                لا توجد بطاقات مطابقة لخيارات التصفية المحددة.
            </div>
        @endforelse
    </div>
</div>
