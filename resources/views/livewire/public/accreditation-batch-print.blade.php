<div class="min-h-screen py-8 px-4 bg-[#F4F7FC] text-[#06205C] print:bg-white print:py-0 print:px-0" dir="rtl">
    
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@700;800;900&display=swap');

    @media print {
        @page {
            size: A4 portrait;
            margin: 0mm !important;
        }
        html, body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Cairo', system-ui, sans-serif !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        /* HIDE ALL LAYOUT HEADERS, NAVBARS, FOOTERS, & MASCOT */
        header, nav, footer, .print\:hidden, x-navbar, x-footer, x-mobile-bottom-nav, #main-navbar, .fixed, [class*="navbar"], [class*="footer"] {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
        main {
            padding: 0 !important;
            margin: 0 !important;
        }
        .a4-sheet-page {
            width: 210mm !important;
            height: 297mm !important;
            max-height: 297mm !important;
            margin: 0 !important;
            padding: 8mm !important;
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            grid-template-rows: repeat(2, 1fr) !important;
            gap: 6mm !important;
            page-break-after: always !important;
            break-after: page !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            box-sizing: border-box !important;
        }
        .batch-card {
            width: 92mm !important;
            height: 135mm !important;
            border-radius: 20px !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            box-shadow: none !important;
        }
    }
    </style>

    <!-- Print Action Header (Hidden when printing) -->
    <div class="max-w-6xl mx-auto mb-8 flex items-center justify-between print:hidden bg-white p-5 rounded-3xl border border-slate-200 shadow-md">
        <div>
            <h1 class="text-2xl font-black text-[#06205C]">طباعة دفعة شارات الاعتماد الرسمية (Batch Badge Print)</h1>
            <p class="text-xs text-slate-500 font-bold mt-0.5">طباعة الشارات الرسمية لجميع الأعضاء المعتمدين على ورق A4 (مقسمة 4 شارات بكل ورقة A4 جاهزة للتقطيع والتثبيت)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.accreditations') }}" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-xs font-bold text-[#06205C] transition shadow-xs">
                رجوع
            </a>
            <button onclick="window.print()" class="px-6 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg transition flex items-center gap-2">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>طباعة جميع الشارات (A4 Batch Print)</span>
            </button>
        </div>
    </div>

    <!-- A4 Sheet Grid Pages (4 Badges per A4 Page) -->
    <div class="max-w-6xl mx-auto space-y-10 print:space-y-0">
        @foreach(collect($users)->chunk(4) as $chunk)
            <div class="a4-sheet-page grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-white/50 rounded-3xl border border-slate-200/60 print:border-0 print:p-0 print:bg-transparent">
                @foreach($chunk as $u)
                    @php
                        $reg       = $u->participant?->registrations?->first();
                        $badge     = $u->badges->first();
                        $userRole  = $u->roles->first()?->name;

                        $roleTitle = $badge?->role_title ?? match ($userRole) {
                            'MEDIA_MANAGER'                     => 'MEDIA',
                            'EXECUTIVE_VIEWER', 'COUNTRY_ADMIN' => 'VIP DIPLOMATIC',
                            'JUDGE', 'EXPERT'                   => 'EXPERT JUDGE',
                            'ORGANIZATION_ADMIN', 'SUPER_ADMIN' => 'ORGANIZER',
                            default                             => 'COMPETITOR',
                        };

                        $roleKey = strtoupper($roleTitle);
                        $theme = match($roleKey) {
                            'SPEAKER' => [
                                'bg'     => 'radial-gradient(circle at 20% 20%, #7C3AED 0%, #4C1D95 40%, #1E1B4B 70%, #D97706 100%)',
                                'badge'  => 'محاضر رئيسي — SPEAKER',
                                'accent' => '#FDE047',
                            ],
                            'MINISTERIAL EXECUTIVE OBSERVER', 'MINISTERIAL_OBSERVER' => [
                                'bg'     => 'radial-gradient(circle at 20% 20%, #7C3AED 0%, #4C1D95 40%, #1E1B4B 70%, #D97706 100%)',
                                'badge'  => 'وزير / مراقب تنفيذي — MINISTERIAL EXECUTIVE OBSERVER',
                                'accent' => '#FFD700',
                            ],
                            'VIP', 'VIP DIPLOMATIC', 'DELEGATION HEAD', 'DELEGATION_HEAD' => [
                                'bg'     => 'radial-gradient(circle at 80% 20%, #059669 0%, #047857 35%, #022C22 75%, #B45309 100%)',
                                'badge'  => 'مسؤول الوفد — DELEGATION HEAD',
                                'accent' => '#FEF08A',
                            ],
                            'EXPERT JUDGE' => [
                                'bg'     => 'radial-gradient(circle at 50% 20%, #4338CA 0%, #312E81 40%, #0F172A 80%, #6D28D9 100%)',
                                'badge'  => 'خبير محكّم — EXPERT JUDGE',
                                'accent' => '#A5B4FC',
                            ],
                            'MEDIA' => [
                                'bg'     => 'radial-gradient(circle at 30% 70%, #D97706 0%, #B45309 40%, #451A03 80%, #78350F 100%)',
                                'badge'  => 'وفد إعلامي — MEDIA / PRESS',
                                'accent' => '#FDE68A',
                            ],
                            'ORGANIZER' => [
                                'bg'     => 'linear-gradient(135deg, #0A192F 0%, #06205C 35%, #0B48A8 70%, #0284C7 100%)',
                                'badge'  => 'منظم رئيسي — ORGANIZER',
                                'accent' => '#38BDF8',
                            ],
                            'VOLUNTEER' => [
                                'bg'     => 'linear-gradient(135deg, #134E4A 0%, #032624 100%)',
                                'badge'  => 'متطوع — VOLUNTEER',
                                'accent' => '#99F6E4',
                            ],
                            default => [
                                'bg'     => 'linear-gradient(135deg, #042F2E 0%, #0D9488 40%, #0284C7 80%, #0369A1 100%)',
                                'badge'  => 'متنافس رسمي — COMPETITOR',
                                'accent' => '#5EEAD4',
                            ],
                        };

                        $token = $reg?->verification_token ?? $badge?->access_token ?? $u->uuid;
                        $verifyUrl = route('verify', ['token' => $token]);
                        $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 250);
                        $nameAr = $u->participant?->first_name_ar ? ($u->participant->first_name_ar . ' ' . $u->participant->last_name_ar) : $u->name;
                        $nameLatin = $u->participant?->first_name_latin ? ($u->participant->first_name_latin . ' ' . $u->participant->last_name_latin) : $u->email;
                    @endphp

                    <!-- INDIVIDUAL 3D BADGE CARD FOR A4 SHEET -->
                    <div class="w-full max-w-[340px] h-[480px] rounded-[2.2rem] text-white p-5 shadow-2xl relative overflow-hidden flex flex-col justify-between border-4 border-white/80 mx-auto batch-card" style="background: {{ $theme['bg'] }};">
                        
                        {{-- Clip Lanyard Simulation Slot --}}
                        <div class="w-14 h-3.5 bg-slate-950/80 border border-white/30 rounded-full mx-auto shadow-inner flex items-center justify-center -mt-2 shrink-0">
                            <div class="w-7 h-1 bg-white/40 rounded-full"></div>
                        </div>

                        {{-- 1. TOP CENTER LOGO: MINISTRY OF VOCATIONAL TRAINING (WHITE & ENGRAVED) --}}
                        <div class="pt-3 pb-1 flex justify-center items-center w-full text-center shrink-0">
                            <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-9 w-auto max-w-[85%] object-contain mx-auto" style="filter: brightness(0) invert(1) drop-shadow(0px -1px 1px rgba(255,255,255,0.75)) drop-shadow(0px 3px 5px rgba(0,0,0,0.92));">
                        </div>

                        {{-- 2. CENTER: GLASSMORPHISM QR PLATE --}}
                        <div class="my-auto text-center shrink-0">
                            <div class="bg-white/20 backdrop-blur-xl rounded-3xl p-3 shadow-2xl mx-auto w-44 h-44 flex flex-col items-center justify-between border-2 border-white/40 shadow-[0_15px_30px_rgba(0,0,0,0.5),inset_0_1px_2px_rgba(255,255,255,0.6)]">
                                <div class="w-32 h-32 bg-white p-1.5 rounded-2xl flex items-center justify-center shadow-inner border border-slate-100">
                                    <img src="{{ $qrCodeUrl }}" alt="Encrypted QR Code" class="w-full h-full object-contain">
                                </div>
                                <div class="text-[7.5px] font-mono font-black text-white/90 uppercase tracking-widest text-center drop-shadow-xs">SECURED BY WSAP ZERO-TRUST</div>
                            </div>
                        </div>

                        {{-- 3. BOTTOM SECTION: USER DETAILS + EVENT PLATFORM LOGO --}}
                        <div class="pt-2 pb-1 flex items-center justify-between border-t border-white/20 px-1 text-right shrink-0">
                            {{-- User Name & Email --}}
                            <div class="space-y-0.5 truncate max-w-[180px]">
                                <h2 class="text-base font-black text-white tracking-tight truncate leading-tight">{{ $nameAr }}</h2>
                                <p class="text-[10px] font-mono font-bold text-slate-200 truncate" dir="ltr">{{ $nameLatin }}</p>
                            </div>

                            {{-- Bottom Left Event Logo --}}
                            <div class="shrink-0 pl-1">
                                <img src="/logo.svg" alt="WorldSkills Event Logo" class="h-8 w-auto object-contain brightness-0 invert opacity-95">
                            </div>
                        </div>

                        {{-- 4. SOVEREIGN ROLE TITLE BANNER --}}
                        <div class="pt-2 border-t border-white/20 shrink-0">
                            <span class="text-[11px] font-black tracking-widest uppercase block text-center py-1 rounded-xl bg-white/10 backdrop-blur-md border border-white/20" style="color: {{ $theme['accent'] }};">
                                {{ $theme['badge'] }}
                            </span>
                        </div>

                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

</div>
