<div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    
    <!-- Printable Trilingual Certificate Container -->
    <div class="bg-white rounded-[2.5rem] p-8 sm:p-12 shadow-2xl border-4 border-brand-500/20 relative overflow-hidden space-y-8 print:p-6 print:shadow-none print:border-2 print:rounded-none" id="printable-certificate">
        
        <!-- Top Official Watermark Header -->
        <div class="flex items-center justify-between border-b-2 border-slate-100 pb-6">
            <div class="flex items-center gap-4">
                <img src="/logo.svg" alt="WorldSkills Algeria" class="h-14 w-auto filter drop-shadow-xs">
                <div>
                    <h2 class="text-xl font-black text-[#06205C] leading-none">WorldSkills Algeria</h2>
                    <span class="text-[10px] font-black text-brand-sky uppercase tracking-widest block mt-1">الجمهورية الجزائرية الديمقراطية الشعبية</span>
                    <span class="text-[9px] text-slate-400 font-mono block">République Algérienne Démocratique et Populaire</span>
                </div>
            </div>

            <div class="text-right font-mono">
                <span class="text-[10px] text-slate-400 font-bold block uppercase">رقم الشهادة / N° Attestation</span>
                <span class="text-sm font-black text-brand-500 bg-brand-50 px-3.5 py-1 rounded-full border border-brand-200 block mt-0.5 shadow-xs">
                    {{ $registration->registration_number }}
                </span>
            </div>
        </div>

        <!-- Trilingual Certificate Titles -->
        <div class="text-center space-y-2">
            <h1 class="text-2xl sm:text-3xl font-black text-[#06205C]">شهادة تسجيل وتأهيل أولمبية رسمية</h1>
            <h2 class="text-sm font-bold text-slate-600 uppercase tracking-widest">Attestation d'Inscription Officielle</h2>
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Official Registration Certificate — WorldSkills Algeria</h3>
        </div>

        @if($lifecycleStatus === 'REVOKED')
            <div class="p-6 rounded-3xl bg-rose-50 border-2 border-rose-300 text-rose-800 text-center space-y-2">
                <div class="flex justify-center text-rose-600"><x-ws.icon name="x-circle" class="w-10 h-10" /></div>
                <h3 class="text-lg font-black">شهادة ملغاة رسمياً — CERTIFICAT ANNULÉ — REVOKED</h3>
                <p class="text-xs font-bold text-rose-600">تم إبطال وإلغاء صلاحية هذه الشهادة من طرف السلطة المنظمة.</p>
                <p class="text-[11px] font-mono text-rose-500">سبب الإلغاء: {{ $registration->revocation_reason ?? 'إلغاء تنظيمي من السلطة المختصة' }}</p>
            </div>
        @endif

        <!-- Candidate Photo & Profile Details Box -->
        <div class="bg-slate-50 rounded-3xl p-6 sm:p-8 border border-slate-200/80 space-y-6">
            
            <div class="flex flex-col sm:flex-row items-center gap-6 border-b border-slate-200 pb-6">
                <!-- Candidate Photo -->
                <img src="{{ $registration->photo_url }}" alt="Candidate Photo" class="w-28 h-36 rounded-2xl object-cover border-2 border-brand-500 shadow-md shrink-0">

                <div class="space-y-2 text-center sm:text-right flex-1">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">اسم ولقب المترشح / Nom & Prénom du Candidat / Candidate Name</span>
                    <h3 class="text-2xl font-black text-[#06205C]">
                        {{ $registration->participant->first_name_ar ?? $registration->user?->name }} {{ $registration->participant->last_name_ar }}
                    </h3>
                    <p class="text-sm font-bold text-slate-600 font-mono">
                        {{ $registration->participant->first_name_latin ?? 'Candidate' }} {{ $registration->participant->last_name_latin }}
                    </p>
                    <p class="text-xs text-slate-500">
                        تاريخ الميلاد / Date de Naissance: <span class="font-mono font-bold">{{ $registration->participant?->date_of_birth ?? '—' }}</span>
                    </p>
                </div>
            </div>

            <!-- Details Grid (Skill, Country, Wilaya, Organization) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs font-semibold text-slate-700">
                <div class="space-y-1">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">التخصص الأولمبي / Métier & Trade</span>
                    <p class="text-sm font-black text-brand-500">
                        {{ $registration->skill ? $registration->skill->code : 'SKILL-01' }} — {{ $registration->skill ? $registration->skill->getLocalized('name') : 'تكنولوجيا المعلومات' }}
                    </p>
                    <p class="text-[11px] text-slate-500 font-mono">{{ $registration->skill?->name_fr }}</p>
                </div>

                <div class="space-y-1">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">الدولة والوفد / Pays & Délégation / Country</span>
                    <p class="text-sm font-bold text-[#06205C]">
                        {{ $registration->country ? $registration->country->getLocalized('name') : 'الجزائر (Algérie)' }}
                    </p>
                </div>

                <div class="space-y-1">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">المؤسسة والولاية / Établissement & Wilaya</span>
                    <p class="text-xs font-bold text-slate-800">
                        {{ $registration->wilaya ? ($registration->wilaya->code . ' - ' . $registration->wilaya->name_ar) : '—' }}
                    </p>
                    <p class="text-[11px] text-slate-600">
                        {{ $registration->organization?->name_ar ?? 'المؤسسة الوطنية المعتمدة' }}
                    </p>
                </div>

                <div class="space-y-1">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block">حالة التوثيق والمعاينة / Statut & Status</span>
                    <div>
                        @if($lifecycleStatus === 'REVOKED')
                            <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-extrabold text-xs">
                                ملغاة رسمياً / Annulé / Revoked
                            </span>
                        @elseif($lifecycleStatus === 'ACTIVE')
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-xs">
                                مقبول معتمداً / Accepté / Approved (ACTIVE)
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-extrabold text-xs">
                                قيد المعاينة / En traitement / Pending Review
                            </span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Verification QR Code Badge & Official Signatures Footer -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 border-t-2 border-slate-100 pt-6">
            <div class="flex items-center gap-4">
                @php
                    $verifyUrl = route('verify', ['token' => $registration->verification_token]);
                    $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 150);
                @endphp
                <!-- Real Dynamic QR Code -->
                <a href="{{ $verifyUrl }}" target="_blank" class="w-24 h-24 bg-white rounded-2xl p-1.5 border-2 border-slate-900 flex items-center justify-center hover:scale-105 transition shadow-lg shrink-0">
                    <img src="{{ $qrCodeUrl }}" alt="Verification QR Code" class="w-full h-full object-contain rounded-xl">
                </a>
                <div class="text-xs space-y-1">
                    <p class="font-bold text-[#06205C]">رمز التحقق المشفر / Code QR de Vérification</p>
                    <p class="text-[10px] text-slate-500 font-mono">Token: {{ $registration->verification_token }}</p>
                    <p class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>امسح الكود بالكاميرا للتحقق الفوري المباشر</span>
                    </p>
                </div>
            </div>

            <div class="text-right">
                <button onclick="window.print()" class="px-6 py-3 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md transition print:hidden inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>طباعة الشهادة الرسمية (Imprimer / Print)</span>
                </button>
            </div>
        </div>

    </div>

</div>
