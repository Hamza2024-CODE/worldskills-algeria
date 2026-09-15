<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الوصف التقني المعتمد — WorldSkills Shanghai 2026</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script>
        (function(){const w=console.warn;console.warn=function(...a){if(a[0]&&typeof a[0]==='string'&&a[0].includes('cdn.tailwindcss.com'))return;w.apply(console,a);};})();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        body {
            font-family: 'Cairo', 'Outfit', sans-serif;
            background: #F1F5F9;
            color: #0F172A;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: #FFFFFF !important; }
            .a4-sheet {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="min-h-screen py-6 px-4">

    {{-- TOP STICKY TOOLBAR (HIDDEN WHEN PRINTING) --}}
    <div class="no-print max-w-5xl mx-auto mb-6 bg-white rounded-2xl p-4 border border-slate-200 shadow-xl flex items-center justify-between gap-4 sticky top-4 z-50 backdrop-blur-md bg-white/95">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#0066FF] text-white flex items-center justify-center font-black text-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h1 class="text-sm font-black text-[#06205C]">
                    {{ $guideSection ? $guideSection->getLocalizedTitle() : ($skill ? $skill->getLocalized('name') : 'الكراسة التقنية الرسمية') }}
                </h1>
                <p class="text-[11px] font-bold text-blue-600">WorldSkills International Shanghai 2026 — Document Viewer</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-[#06205C] hover:bg-[#041640] text-amber-300 font-black text-xs transition shadow flex items-center gap-1.5 border border-amber-400/40">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>طباعة الكراسة (Print A4)</span>
            </button>
            
            <button onclick="window.close()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                إغلاق النافذة
            </button>
        </div>
    </div>

    {{-- MAIN A4 DOCUMENT CONTAINER --}}
    <div class="max-w-4xl mx-auto bg-white rounded-3xl p-8 sm:p-12 shadow-2xl border border-slate-200 space-y-8 a4-sheet">

        {{-- DOCUMENT HEADER BANNER --}}
        <div class="border-b-4 border-[#0066FF] pb-6 flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="px-3 py-1 rounded-full bg-blue-50 text-[#0066FF] font-mono font-black text-xs border border-blue-200 inline-block">
                    Official Technical Description
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-[#06205C]">
                    {{ $guideSection ? $guideSection->getLocalizedTitle() : ($skill ? $skill->getLocalized('name') : 'الوصف التقني الفني') }}
                </h2>
                <p class="text-xs font-bold text-slate-500">
                    WorldSkills International Shanghai 2026 — Skill Competitions Committee Resolution
                </p>
            </div>
            
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#06205C] to-[#0066FF] text-white flex items-center justify-center font-black text-xl shadow-lg shrink-0">
                WSI
            </div>
        </div>

        {{-- SKILL METRICS HIGHLIGHT --}}
        @if($skill)
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs">
                <div>
                    <span class="text-[10px] text-slate-400 font-bold block uppercase">رمز المهنة</span>
                    <span class="font-black text-[#0066FF] font-mono text-sm">{{ $skill->code }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-bold block uppercase">شرط السن الأقصى</span>
                    <span class="font-black text-emerald-600 text-sm">{{ $skill->max_age }} سنة</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-bold block uppercase">نوع المشاركة</span>
                    <span class="font-black text-slate-800 text-sm">منافسة فردية</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-bold block uppercase">حالة الاعتماد</span>
                    <span class="font-black text-purple-600 text-sm">معتمد رسمياً WSI</span>
                </div>
            </div>
        @endif

        {{-- DOCUMENT BODY CONTENT --}}
        <div class="prose max-w-none text-slate-800 text-sm leading-relaxed space-y-6">
            @if($guideSection)
                <div class="whitespace-pre-line">
                    {!! nl2br(e($guideSection->getLocalizedBody())) !!}
                </div>
            @elseif($skill)
                <div class="whitespace-pre-line bg-slate-50 p-6 rounded-2xl border border-slate-200">
                    {!! nl2br(e($skill->getLocalized('description'))) !!}
                </div>
            @endif
        </div>

        {{-- ASSESSMENT MODULES BREAKDOWN (IF SKILL ATTACHED) --}}
        @if($skill && $skill->assessmentModules->count() > 0)
            <div class="pt-6 border-t border-slate-200 space-y-4">
                <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2">
                    <span class="flex items-center gap-1.5"><x-ws.icon name="chart-bar" class="w-5 h-5 text-brand-600" /> معايير التقييم والأوزان النسبية (WSOS Assessment Breakdown)</span>
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-xs rounded-2xl overflow-hidden border border-slate-200">
                        <thead>
                            <tr class="bg-[#06205C] text-white">
                                <th class="p-3 text-right font-black">الكود</th>
                                <th class="p-3 text-right font-black">وحدة التقييم والمعيار المهني</th>
                                <th class="p-3 text-center font-black">الوزن النسبي (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skill->assessmentModules as $idx => $mod)
                                <tr class="{{ $idx % 2 === 0 ? 'bg-white' : 'bg-slate-50' }} border-b border-slate-100">
                                    <td class="p-3 font-mono font-bold text-[#0066FF]">{{ $mod->code }}</td>
                                    <td class="p-3 font-bold text-slate-800">{{ $mod->title_ar }}</td>
                                    <td class="p-3 text-center font-black text-emerald-600 bg-emerald-50/50">{{ $mod->max_score }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- DOCUMENT FOOTER SIGNATURE --}}
        <div class="pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 font-medium gap-4">
            <div>
                <p class="font-bold text-slate-700">WorldSkills International — Competitions Committee</p>
                <p class="text-[10px] text-slate-400">Constitution, Standing Orders, and Competition Rules Standard Edition 2026</p>
            </div>
            <div class="text-left font-mono text-[10px]">
                <p>Doc Ref: WSC2026_TD_OFFICIAL</p>
                <p>Status: VERIFIED & SEALED</p>
            </div>
        </div>

    </div>

</body>
</html>
