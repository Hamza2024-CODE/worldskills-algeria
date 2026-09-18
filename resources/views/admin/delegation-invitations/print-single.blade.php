@php
$locale = app()->getLocale();
$c = $invitation['country'];
$cName = $c->name_ar . ' (' . $c->name_en . ')';
$qrUrl = \App\Services\QrCodeService::generateDataUri($invitation['login_url'], 350);
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        (function(){const w=console.warn;console.warn=function(...a){if(a[0]&&typeof a[0]==='string'&&a[0].includes('cdn.tailwindcss.com'))return;w.apply(console,a);};})();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        *, ::before, ::after {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            min-height: 100vh !important;
            background-color: #0f172a !important;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .a4-page {
            width: 210mm;
            height: 297mm;
            margin: 20px auto;
            padding: 10mm;
            box-sizing: border-box;
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border-radius: 1.5rem;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            html, body {
                background: #ffffff !important;
                width: 210mm !important;
                height: 297mm !important;
                overflow: hidden !important;
            }
            .a4-page {
                width: 210mm !important;
                height: 297mm !important;
                margin: 0 !important;
                padding: 10mm !important;
                box-sizing: border-box !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                page-break-after: avoid !important;
                page-break-inside: avoid !important;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-start p-4">

    <!-- Top Floating Controls (Hidden when printing) -->
    <div class="no-print w-full max-w-[210mm] py-4 flex items-center justify-between px-2">
        <a href="{{ route('admin.countries') }}" class="px-4 py-2 rounded-xl bg-slate-800 text-white font-bold text-xs hover:bg-slate-700 transition flex items-center gap-2 border border-slate-700">
            ← العودة إلى قائمة دعوات الوفود
        </a>

        <button onclick="window.print()" class="px-6 py-2.5 rounded-xl bg-[#06205C] text-amber-300 font-black text-xs shadow-lg hover:bg-blue-900 transition flex items-center gap-2 border border-amber-400/40">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>طباعة بطاقة الدعوة السيادية (Print A4)</span>
        </button>
    </div>

    <!-- PURE A4 DIPLOMATIC INVITATION CANVAS (CENTERED) -->
    <div class="a4-page flex flex-col justify-between border-4 border-[#06205C] p-8 bg-gradient-to-b from-white via-slate-50 to-amber-50/20 text-slate-900 relative">
        
        <!-- Header Banner & State Seal -->
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b-2 border-amber-400 pb-4">
                <img src="/LOGO01.png" alt="State Seal" class="h-20 w-auto object-contain">
                
                <div class="text-center space-y-1">
                    <p class="text-xs font-black uppercase text-[#06205C] tracking-wider">الجمهورية الجزائرية الديمقراطية الشعبية — وزارة التكوين والتعليم المهنيين</p>
                    <h1 class="text-2xl font-black text-[#06205C] tracking-tight">WORLDSKILLS AFRICA 2026 ALGIERS</h1>
                    <p class="text-xs font-bold text-amber-700">المركّب الأولمبي والقرية الإفريقية للمهن — الجزائر العاصمة</p>
                </div>

                <img src="/logo.svg" alt="WorldSkills Logo" class="h-14 w-auto object-contain">
            </div>

            <!-- Invitation Body Text -->
            <div class="space-y-5 text-center py-4">
                <span class="px-6 py-1.5 rounded-full bg-[#06205C] text-amber-300 font-black text-xs inline-block shadow-sm">
                    بطاقة دعوة سيادية وبيانات اعتماد حساب إدارة الوفد الرسمية
                </span>

                <h2 class="text-3xl font-black text-slate-900">
                    دعوة رسمية موجهة إلى وفد دولة: <br>
                    <span class="text-[#06205C] text-3xl underline decoration-amber-400 font-black inline-block mt-2">{{ $cName }}</span>
                </h2>

                <p class="text-sm text-slate-700 leading-relaxed max-w-xl mx-auto font-medium">
                    تتشرف الخلية الوطنية المنظمة لأولمبياد المهن الإفريقية 2026 بالجمهورية الجزائرية بدعوة وفد دولتكم الموقرة للمشاركة والتسجيل رسمياً عبر البوابة الموحدة لإدارة الوفود.
                </p>
            </div>
        </div>

        <!-- Access Credentials & QR Code Diploma Box -->
        <div class="p-6 rounded-2xl bg-[#06205C] text-white space-y-4 border-2 border-amber-400 shadow-md my-4" style="-webkit-print-color-adjust: exact !important; background-color: #06205C !important; color: #ffffff !important;">
            <div class="flex items-center justify-between gap-6">
                
                <div class="space-y-3 flex-1 min-w-0">
                    <h3 class="text-xs font-black text-amber-300 uppercase tracking-widest border-b border-blue-800 pb-2">
                        بيانات الدخول والوصول الآمن لحساب إدارة الوفد (Delegation Credentials):
                    </h3>

                    <div class="space-y-3 text-xs font-mono">
                        <div class="bg-[#041640] p-3.5 rounded-xl border border-blue-700/80 flex items-center justify-between gap-4" style="-webkit-print-color-adjust: exact !important; background-color: #041640 !important;">
                            <span class="text-xs text-amber-300 font-bold uppercase font-sans shrink-0">اسم المستخدم (Login Email):</span>
                            <span class="font-black text-white text-sm font-mono select-all text-left dir-ltr">{{ $invitation['email'] }}</span>
                        </div>

                        <div class="bg-[#041640] p-3.5 rounded-xl border border-blue-700/80 flex items-center justify-between gap-4" style="-webkit-print-color-adjust: exact !important; background-color: #041640 !important;">
                            <span class="text-xs text-amber-300 font-bold uppercase font-sans shrink-0">كلمة المرور الأولية (Password):</span>
                            <span class="font-black text-amber-400 text-sm font-mono select-all text-left dir-ltr">{{ $invitation['password'] }}</span>
                        </div>
                    </div>

                    <div class="text-xs text-slate-300 font-medium pt-1">
                        رابط تسجيل الدخول المباشر: <span class="text-amber-300 font-mono font-bold">{{ $invitation['login_url'] }}</span>
                    </div>
                </div>

                <!-- QR Code Box -->
                <div class="bg-white p-3 rounded-2xl shrink-0 border-2 border-amber-400 shadow-md text-center">
                    <img src="{{ $qrUrl }}" alt="QR Code Login Verification" class="w-32 h-32 object-contain">
                    <span class="text-[9px] font-mono font-black text-slate-700 block mt-1.5">SCAN FOR INSTANT ACCESS</span>
                </div>

            </div>
        </div>

        <!-- Footer Verification Stamp -->
        <div class="flex items-center justify-between text-xs font-bold text-slate-500 pt-4 border-t-2 border-amber-400">
            <span>الرمز السيادي لتأكيد الدعوة: WSAP-INV-{{ $c->iso2 ?: 'AF' }}-2026</span>
            <span>معتمدة رسمياً من قبل اللجنة التنفيذية لأولمبياد المهن الإفريقية</span>
        </div>

    </div>

    <script>
        // Auto trigger print dialog on page load
        window.addEventListener('load', () => {
            setTimeout(() => {
                window.print();
            }, 600);
        });
    </script>
</body>
</html>
