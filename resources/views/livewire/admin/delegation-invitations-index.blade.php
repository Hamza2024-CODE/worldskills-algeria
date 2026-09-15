@php
$locale = app()->getLocale();
$dir = $locale === 'ar' ? 'rtl' : 'ltr';
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 font-sans text-slate-900 dark:text-white" dir="{{ $dir }}">

    {{-- Printable Sovereign Invitation Letter & Card Print Engine --}}
    <style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 0;
        }
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: 100% !important;
            overflow: hidden !important;
            background: #ffffff !important;
        }
        body * {
            visibility: hidden !important;
        }
        .print-invitation-area, .print-invitation-area * {
            visibility: visible !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        .print-invitation-area {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            max-width: none !important;
            max-height: none !important;
            margin: 0 !important;
            padding: 8mm !important;
            box-sizing: border-box !important;
            background: #ffffff !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            z-index: 999999 !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
        }
        .print-diploma-card {
            width: 100% !important;
            height: 100% !important;
            max-width: 100% !important;
            max-height: 100% !important;
            margin: 0 !important;
            padding: 8mm !important;
            box-sizing: border-box !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
        }
        .print\:hidden {
            display: none !important;
        }
    }
    </style>

    <!-- Top Sovereign Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0A3580] p-8 border-2 border-amber-400/40 shadow-xl text-white print:hidden">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-sky-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 border border-amber-400/40 text-amber-300 text-xs font-black">
                    <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>{{ $t('مركز الدعوات السيادية للوفود الإفريقية', 'Centre des Invitations Souveraines', 'Sovereign African Invitations Portal') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    {{ $t('سجل دعوات وبيانات اعتماد الوفود الإفريقية 54', 'Registre des Invitations des 54 Délégations Africaines', '54 African Delegations Sovereign Invitations & Credentials Register') }}
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm max-w-2xl font-medium">
                    {{ $t('منصة طباعة وتصدير بطاقات الدخول الرسمية والدعوات السيادية المرفقة بـ QR Code واسم المستخدم وكلمة السر.', 'Plateforme d\'impression des invitations officielles avec QR code, identifiants et mot de passe.', 'Official printing portal for African delegation sovereign invitation passes with QR code & credentials.') }}
                </p>
            </div>
            
            <div class="shrink-0 flex items-center gap-3">
                <img src="/LOGO01.png" alt="State Seal" class="h-16 w-auto object-contain filter drop-shadow-md">
                <img src="/logo.svg" alt="WorldSkills Logo" class="h-12 w-auto filter brightness-0 invert">
            </div>
        </div>
    </div>

    <!-- Search & Filter Toolbar -->
    <div class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4 print:hidden">
        <div class="w-full sm:w-96 relative">
            <input type="text" wire:model.live="search" placeholder="{{ $t('بحث باسم الدولة، الكود، أو البريد...', 'Rechercher par pays, code, email...', 'Search by country, ISO, email...') }}" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-3 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-amber-300 font-black text-xs shadow-md transition flex items-center gap-2 border border-amber-400/40">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>{{ $t('طباعة السجل الشامل لجميع الوفود', 'Imprimer Tout le Registre', 'Print All Delegations Credentials') }}</span>
            </button>
        </div>
    </div>

    <!-- Grid of Delegation Invitation Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 print:hidden">
        @foreach($delegationsData as $item)
            @php
                $c = $item['country'];
                $cName = $locale === 'fr' ? ($c->name_fr ?? $c->name_en) : ($locale === 'en' ? $c->name_en : $c->name_ar);
                $qrUrl = \App\Services\QrCodeService::generateDataUri($item['login_url'], 250);
            @endphp

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-6 shadow-md space-y-5 flex flex-col justify-between hover:border-blue-500 transition">
                <div class="space-y-4">
                    
                    <!-- Card Top Header -->
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-900 font-mono font-black flex items-center justify-center text-xs shadow-xs">
                                {{ $c->iso2 ?: 'AF' }}
                            </span>
                            <div>
                                <h3 class="text-base font-black text-[#06205C] dark:text-white leading-tight">{{ $cName }}</h3>
                                <span class="text-[10px] text-slate-400 block font-bold font-mono">{{ $c->name_en }}</span>
                            </div>
                        </div>

                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-200 border border-emerald-200">
                            {{ $t('دعوة رسمية مفعلة', 'Invitation Activée', 'Invitation Active') }}
                        </span>
                    </div>

                    <!-- Delegation Head Info -->
                    <div class="bg-slate-50 dark:bg-slate-900 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">{{ $t('قائد ومسؤول الوفد المعتمد', 'Chef de Délégation', 'Head of Delegation') }}</span>
                        <span class="text-xs font-black text-slate-900 dark:text-white block">{{ $item['user']?->name ?? ($cName . ' Delegation Head') }}</span>
                    </div>

                    <!-- QR Code & Credentials Box -->
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-[#06205C] to-blue-900 text-white shadow-md space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <div class="space-y-2 flex-1">
                                <div>
                                    <span class="text-[9px] text-amber-300 font-bold block uppercase">{{ $t('اسم المستخدم (User Email):', 'Identifiant / E-mail:', 'Username / Email:') }}</span>
                                    <span class="text-xs font-mono font-black text-white select-all block truncate">{{ $item['email'] }}</span>
                                </div>

                                <div>
                                    <span class="text-[9px] text-amber-300 font-bold block uppercase">{{ $t('كلمة المرور الأولية (Password):', 'Mot de Passe:', 'Initial Password:') }}</span>
                                    <span class="text-xs font-mono font-black text-amber-400 select-all block">{{ $item['password'] }}</span>
                                </div>
                            </div>

                            <!-- QR Code Preview -->
                            <div class="w-16 h-16 bg-white p-1 rounded-xl shrink-0 shadow-md flex items-center justify-center">
                                <img src="{{ $qrUrl }}" alt="QR Code" class="w-full h-full object-contain">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Action Button: Open Printable Sovereign Card Modal -->
                <a href="{{ route('admin.delegation.invitations.print.single', $c->id) }}" target="_blank" class="w-full py-2.5 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-amber-300 font-black text-xs shadow-md transition flex items-center justify-center gap-2 border border-amber-400/40">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>{{ $t('معاينة وطباعة بطاقة الدعوة الرسمية (A4) ↗', 'Imprimer l\'Invitation (A4) ↗', 'Inspect & Print Sovereign Invitation (A4) ↗') }}</span>
                </a>

            </div>
        @endforeach
    </div>

    <!-- SOVEREIGN PRINTABLE INVITATION MODAL -->
    @if(($showPrintModal ?? false) && ($selectedInvitation ?? null))
        @php
            $invC = $selectedInvitation['country'];
            $invCName = $locale === 'fr' ? ($invC->name_fr ?? $invC->name_en) : ($locale === 'en' ? $invC->name_en : $invC->name_ar);
            $invQrUrl = \App\Services\QrCodeService::generateDataUri($selectedInvitation['login_url'], 300);
        @endphp

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm print:static print:p-0 print:m-0 print:bg-white print:block print:w-full print:h-full" x-data>
            <div class="bg-white rounded-3xl max-w-2xl w-full p-8 space-y-6 shadow-2xl border border-slate-200 max-h-[95vh] overflow-y-auto print:max-w-none print:w-full print:h-full print:shadow-none print:border-none print:p-0 print:m-0 print-invitation-area">
                
                <!-- Modal Top Toolbar (Hidden when printing) -->
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 print:hidden">
                    <h3 class="text-base font-black text-[#06205C] flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>{{ $t('بطاقة الدعوة السيادية الرسمية لوفد دولة', 'Invitation Souveraine Officielle pour la Délégation de', 'Official Sovereign Invitation Certificate for') }}: {{ $invCName }}</span>
                    </h3>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.delegation.invitations.print.single', $invC->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-[#06205C] hover:bg-[#041640] text-amber-300 font-black text-xs shadow-md transition flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>{{ $t('فتح النافذة المخصصة للطباعة (A4) ↗', 'Imprimer A4 ↗', 'Print A4 Sovereign Certificate ↗') }}</span>
                        </a>
                        <button wire:click="$set('showPrintModal', false)" class="px-3 py-2 text-slate-400 hover:text-slate-600 font-bold text-sm"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                    </div>
                </div>

                <!-- SOVEREIGN DIPLOMATIC INVITATION DIPLOMA CARD -->
                <div class="p-8 rounded-3xl bg-gradient-to-b from-white via-slate-50 to-amber-50/20 border-4 border-[#06205C] shadow-xl space-y-6 text-slate-900 print-diploma-card">
                    
                    <!-- Emblem & Logos Banner -->
                    <div class="flex items-center justify-between border-b-2 border-amber-400 pb-4">
                        <img src="/LOGO01.png" alt="State Seal" class="h-20 w-auto object-contain">
                        
                        <div class="text-center space-y-1">
                            <p class="text-[10px] font-black uppercase text-[#06205C] tracking-wider">الجمهورية الجزائرية الديمقراطية الشعبية — وزارة التكوين والتعليم المهنيين</p>
                            <h2 class="text-xl font-black text-[#06205C] tracking-tight">WORLDSKILLS AFRICA 2026 ALGIERS</h2>
                            <p class="text-xs font-bold text-amber-700">المركّب الأولمبي والقرية الإفريقية للمهن — الجزائر العاصمة</p>
                        </div>

                        <img src="/logo.svg" alt="WorldSkills Logo" class="h-14 w-auto object-contain">
                    </div>

                    <!-- Invitation Body -->
                    <div class="space-y-4 text-center py-2">
                        <span class="px-4 py-1 rounded-full bg-[#06205C] text-amber-300 font-black text-xs inline-block">
                            بطاقة دعوة سيادية وبيانات اعتماد حساب إدارة الوفد الرسمية
                        </span>

                        <h3 class="text-2xl font-black text-slate-900">
                            دعوة رسمية موجهة إلى وفد دولة: <span class="text-[#06205C] underline decoration-amber-400 font-black">{{ $invCName }} ({{ $invC->name_en }})</span>
                        </h3>

                        <p class="text-xs text-slate-700 leading-relaxed max-w-xl mx-auto font-medium">
                            تتشرف الخلية الوطنية المنظمة لأولمبياد المهن الإفريقية 2026 بالجمهورية الجزائرية بدعوة وفد دولتكم الموقرة للمشاركة والتسجيل رسمياً عبر البوابة الموحدة لإدارة الوفود.
                        </p>
                    </div>

                    <!-- Access Credentials & QR Code Diploma Box -->
                    <div class="p-6 rounded-2xl bg-[#06205C] text-white space-y-4 border-2 border-amber-400 shadow-md" style="-webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; background-color: #06205C !important; color: #ffffff !important;">
                        <div class="flex items-center justify-between gap-6">
                            <div class="space-y-3 flex-1 min-w-0">
                                <h4 class="text-xs font-black text-amber-300 uppercase tracking-widest border-b border-blue-800 pb-2">
                                    بيانات الدخول والوصول الآمن لحساب إدارة الوفد (Delegation Credentials):
                                </h4>

                                <div class="space-y-2.5 text-xs font-mono">
                                    <div class="bg-[#041640] p-3 rounded-xl border border-blue-700/80 flex items-center justify-between gap-4" style="-webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; background-color: #041640 !important;">
                                        <span class="text-[10px] text-amber-300 font-bold uppercase font-sans shrink-0">اسم المستخدم (Login Email):</span>
                                        <span class="font-black text-white text-xs sm:text-sm font-mono select-all text-left dir-ltr truncate">{{ $selectedInvitation['email'] }}</span>
                                    </div>

                                    <div class="bg-[#041640] p-3 rounded-xl border border-blue-700/80 flex items-center justify-between gap-4" style="-webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; background-color: #041640 !important;">
                                        <span class="text-[10px] text-amber-300 font-bold uppercase font-sans shrink-0">كلمة المرور الأولية (Password):</span>
                                        <span class="font-black text-amber-400 text-xs sm:text-sm font-mono select-all text-left dir-ltr">{{ $selectedInvitation['password'] }}</span>
                                    </div>
                                </div>

                                <div class="text-[10px] text-slate-300 font-medium">
                                    رابط تسجيل الدخول المباشر: <span class="text-amber-300 font-mono font-bold">{{ $selectedInvitation['login_url'] }}</span>
                                </div>
                            </div>

                            <!-- QR Code Box -->
                            <div class="bg-white p-2.5 rounded-2xl shrink-0 border-2 border-amber-400 shadow-md text-center">
                                <img src="{{ $invQrUrl }}" alt="QR Code Login Verification" class="w-28 h-28 object-contain">
                                <span class="text-[8px] font-mono font-black text-slate-700 block mt-1">SCAN FOR INSTANT ACCESS</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Verification Stamp -->
                    <div class="flex items-center justify-between text-[10px] font-bold text-slate-500 pt-2 border-t border-slate-200">
                        <span>الرمز السيادي لتأكيد الدعوة: WSAP-INV-{{ $invC->iso2 ?: 'AF' }}-2026</span>
                        <span>معتمدة رسمياً من قبل اللجنة التنفيذية لأولمبياد المهن الإفريقية</span>
                    </div>

                </div>

            </div>
        </div>
    @endif

</div>
