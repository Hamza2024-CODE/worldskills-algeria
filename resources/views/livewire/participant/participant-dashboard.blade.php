<div class="space-y-8 pb-12" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    @php
        $reg = $registration;
        $prof = $profile;
        $authUser = auth()->user();

        $nameAr = trim(($prof?->first_name_ar ?? '') . ' ' . ($prof?->last_name_ar ?? ''));
        $nameFr = trim(($prof?->first_name_fr ?? '') . ' ' . ($prof?->last_name_fr ?? ''));
        
        $candidateName = $nameAr;
        if (empty($candidateName)) {
            $candidateName = $nameFr;
        }
        if (empty($candidateName)) {
            $candidateName = $authUser?->name ?? 'متنافس أولمبي';
        }

        $photoUrl = $reg?->photo_url;
        if (!$photoUrl && $authUser?->avatar) {
            $photoUrl = asset('storage/' . ltrim($authUser->avatar, '/'));
        }

        $suitSize = $editSuitSize ?? ($reg?->suit_size ?? 'M');
        $shoeSize = $editShoeSize ?? ($reg?->shoe_size ?? '42');
        $heightCm = $editHeightCm ?? ($reg?->height_cm ?? '175');

        $statusRaw = is_object($reg?->status) ? ($reg->status->value ?? 'APPROVED') : ($reg?->status ?? 'APPROVED');
        $statusKey = strtoupper((string) $statusRaw);

        $rejectionReason = $reg?->rejection_reason ?? ($reg?->revocation_reason ?? 'عدم استيفاء الشروط التنظيمية أو السن المطلوب للتنافس.');

        $statusBadgeClass = match($statusKey) {
            'QUALIFIED_NATIONAL' => 'bg-amber-500 text-white border-amber-300 shadow-amber-500/20',
            'QUALIFIED_REGIONAL' => 'bg-[#0066FF] text-white border-blue-300 shadow-blue-500/20',
            'APPROVED'           => 'bg-emerald-500 text-white border-emerald-300 shadow-emerald-500/20',
            'REJECTED'           => 'bg-rose-600 text-white border-rose-300 shadow-rose-500/20',
            default              => 'bg-slate-600 text-white border-slate-300',
        };

        $statusLabelAr = match($statusKey) {
            'QUALIFIED_NATIONAL' => 'متأهل للنهائيات الوطنية ',
            'QUALIFIED_REGIONAL' => 'متأهل للبطولة الجهوية  (بطل الولاية)',
            'APPROVED'           => 'مقبول رسمياً بالبطولة الولائية ',
            'REJECTED'           => 'مرفوض ',
            default              => 'قيد المعالجة والتدقيق ',
        };

        $statusLabelFr = match($statusKey) {
            'QUALIFIED_NATIONAL' => 'Qualifié Finale Nationale ',
            'QUALIFIED_REGIONAL' => 'Qualifié Régional  (Champion Wilaya)',
            'APPROVED'           => 'Homologué Officiellement ',
            'REJECTED'           => 'Refusé / Non Retenu ',
            default              => 'En Cours de Traitement ',
        };

        $isEligibleForBadge = in_array($statusKey, ['APPROVED', 'QUALIFIED_REGIONAL', 'QUALIFIED_NATIONAL']);

        $wilayaName = $reg?->wilaya?->name_ar ?? ($prof?->wilaya?->name_ar ?? 'ولاية الجزائر');
        $orgName = $reg?->organization?->name_ar ?? ($prof?->organization?->name_ar ?? 'المؤسسة التكوينية المعتمدة');
        $ninNumber = $prof?->national_id ?? ($authUser?->national_id ?? 'غير مسجل');
        $dob = $prof?->date_of_birth ? date('Y-m-d', strtotime($prof->date_of_birth)) : 'غير محدد';
        $age = $prof?->date_of_birth ? (date('Y') - date('Y', strtotime($prof->date_of_birth))) : null;
        $phoneNum = $prof?->phone ?? ($authUser?->phone ?? 'غير مسجل');
        $emailAddr = $prof?->email ?? ($authUser?->email ?? 'غير مسجل');
    @endphp

    @if(!empty($successMessage))
        <div class="p-4 rounded-2xl bg-emerald-500 text-white font-bold text-xs flex items-center justify-between shadow-lg animate-fade-in">
            <div class="flex items-center gap-2">
                <x-ws.icon name="check-circle" class="w-4 h-4 text-white" />
                <span>{{ $successMessage }}</span>
            </div>
            <button type="button" wire:click="$set('successMessage', '')" class="text-white/80 hover:text-white font-black text-sm"><x-ws.icon name="x-mark" class="w-4 h-4" /></button>
        </div>
    @endif

    <!-- ══ Executive Hero Banner ══ -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white p-6 sm:p-10 shadow-2xl border border-white/10">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="relative shrink-0">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-tr from-amber-400 via-blue-400 to-white p-1 shadow-xl overflow-hidden">
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $candidateName }}" class="w-full h-full rounded-[14px] object-cover border border-white/20">
                        @else
                            <div class="w-full h-full rounded-[14px] bg-[#06205C] flex items-center justify-center text-white font-black text-2xl sm:text-3xl border border-white/20">
                                {{ mb_substr($candidateName ?? 'م', 0, 1) }}
                            </div>
                        @endif
                    </div>
                    @if($isEligibleForBadge)
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-emerald-500 border-2 border-[#06205C] flex items-center justify-center text-[10px] text-white shadow-xs" title="حساب موثق ومقبول"><x-ws.icon name="check" class="w-3.5 h-3.5 text-white" /></span>
                    @else
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-rose-500 border-2 border-[#06205C] flex items-center justify-center text-[10px] text-white shadow-xs" title="مرفوض"><x-ws.icon name="x-mark" class="w-3.5 h-3.5 text-white" /></span>
                    @endif
                </div>

                <div class="space-y-1.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 rounded-full border text-xs font-black tracking-wide flex items-center gap-1.5 {{ $statusBadgeClass }}">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                            <span>{{ app()->getLocale() === 'fr' ? $statusLabelFr : $statusLabelAr }}</span>
                        </span>
                        <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-slate-200 text-xs font-mono font-bold">
                            {{ $reg?->registration_number ?? 'WSAP-2026-DZ' }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white flex items-center gap-2">
                        <span>{{ $candidateName }}</span>
                        @if(!empty($nameFr) && $nameFr !== $candidateName)
                            <span class="text-xs font-mono font-normal text-blue-200/80 dir-ltr">({{ $nameFr }})</span>
                        @endif
                    </h1>
                    
                    <p class="text-xs text-amber-200 font-bold">
                        {{ app()->getLocale() === 'fr' ? 'Bienvenue dans votre espace compétiteur officiel — WorldSkills Algeria' : (app()->getLocale() === 'en' ? 'Welcome to your official competitor dashboard — WorldSkills' : 'مرحباً بك في فضاء المتنافس الأولمبي — المنصة الوطنية الرسمية لأولمبياد المهن الجزائرية') }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <p class="text-xs sm:text-sm text-blue-100/90 font-bold flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            <span>التخصص التنافسي: </span>
                            <strong class="text-amber-300 font-extrabold">{{ $reg?->skill?->getLocalized('name') ?? 'التخصص الأولمبي الموحد' }}</strong>
                        </p>

                        <div class="flex items-center gap-2 sm:ps-3 border-s border-white/20">
                            <span class="px-2.5 py-0.5 rounded-lg bg-white/10 border border-white/20 text-xs font-mono font-bold text-amber-200" title="مقاس البدلة">
                                بدلة: {{ $suitSize }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-lg bg-white/10 border border-white/20 text-xs font-mono font-bold text-amber-200" title="مقاس الحذاء">
                                حذاء: {{ $shoeSize }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Pass Button (Only for Eligible Approved Candidates) -->
            <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                @if($isEligibleForBadge)
                    <button type="button" @click="showBadgeModal = true" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-amber-400 via-amber-500 to-amber-400 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-black text-xs shadow-xl shadow-amber-500/30 transition transform hover:scale-105 active:scale-95 flex items-center gap-2 border border-amber-300">
                        <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>بطاقة الاعتماد والشهادة</span>
                    </button>
                @else
                    <div class="px-4 py-2.5 rounded-2xl bg-rose-500/20 border border-rose-400/30 text-rose-200 text-xs font-bold flex items-center gap-1.5">
                        <x-ws.icon name="exclamation-triangle" class="w-4 h-4 text-rose-400" />
                        <span>الشارة غير متاحة</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ══ Dynamic Real Competition Stepper & Rejection Banner ══ -->
    @if($statusKey === 'REJECTED')
        <!-- Rejection Alert Notification Banner -->
        <div class="p-6 rounded-3xl bg-rose-50 border-2 border-rose-300 space-y-3 shadow-lg animate-fade-in">
            <div class="flex items-center gap-3 text-rose-900">
                <div class="w-10 h-10 rounded-2xl bg-rose-500 text-white flex items-center justify-center font-black text-lg shrink-0">
                    
                </div>
                <div>
                    <h3 class="text-base font-black text-rose-900">نتيجة دراسة الترشح: تم رفض الملف</h3>
                    <span class="text-xs text-rose-600 font-bold block">قرار اللجنة الإدارية والفنية المكلفة بالتأهل</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-rose-200 space-y-1.5">
                <span class="text-xs font-black text-rose-800 block">سبب الرفض المسجل بالنظام:</span>
                <p class="text-xs font-bold text-slate-800 leading-relaxed">
                    {{ $rejectionReason }}
                </p>
            </div>

            <p class="text-[11px] text-rose-700 font-medium leading-relaxed">
                ملاحظة: في حال وجود أي استفسار أو اعتراض فني، يمكنكم التقدم بطعن إداري عبر اللجنة الولائية للتكوين المهني.
            </p>
        </div>
    @endif

    <!-- 5-Step Dynamic Journey Stepper -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200/80 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#0066FF] animate-ping"></span>
                    <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                        مسار التنافس والاعتماد الأولمبي الرسمي
                    </h3>
                </div>
                <p class="text-xs text-slate-800 font-bold">
                    متابعة دقيقة لمراحل التأهل والجاهزية للمشاركة في البطولة الوطنية والإفريقية.
                </p>
            </div>
            <div class="px-4 py-1.5 rounded-full bg-gradient-to-r from-[#0066FF] to-[#00B8FF] text-white text-xs font-black shadow-md shadow-blue-500/20 self-start sm:self-auto flex items-center gap-1.5 shrink-0">
                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                <span>
                    @if($statusKey === 'REJECTED')
                        المرحلة 2 (مرفوض)
                    @elseif($statusKey === 'PENDING')
                        المرحلة 2 من أصل 5
                    @elseif($statusKey === 'APPROVED')
                        المرحلة 3 من أصل 5
                    @elseif($statusKey === 'QUALIFIED_REGIONAL')
                        المرحلة 4 من أصل 5
                    @else
                        المرحلة 5 من أصل 5
                    @endif
                </span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                
                <!-- Step 1: Application Submission -->
                <div class="p-5 rounded-2xl bg-gradient-to-br from-emerald-500/10 via-emerald-50/40 to-white border border-emerald-300 space-y-3 shadow-xs">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-emerald-400 text-white font-black text-xs flex items-center justify-center shadow-md shadow-emerald-500/20"><x-ws.icon name="check" class="w-4 h-4 text-white" /></div>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-wider">مكتمل</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-900 leading-tight">① تقديم الطلب والملف</h4>
                        <p class="text-[11px] text-slate-600 font-medium mt-1 leading-snug">تم استقبال الملف وتسجيله بالمنصة الوطنية.</p>
                    </div>
                </div>

                <!-- Step 2: Administrative Audit / Verification -->
                @if($statusKey === 'REJECTED')
                    <div class="p-5 rounded-2xl bg-rose-50 border-2 border-rose-400 space-y-3 shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-rose-600 text-white font-black text-xs flex items-center justify-center shadow-md"></div>
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-200 text-rose-900 text-[10px] font-black uppercase tracking-wider">مرفوض</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-rose-900 leading-tight">② التدقيق والفرز الإداري</h4>
                            <p class="text-[11px] text-rose-700 font-bold mt-1 leading-snug">تمت معالجة الملف وتبين عدم استيفاء الشروط.</p>
                        </div>
                    </div>
                @elseif($statusKey === 'PENDING')
                    <div class="p-5 rounded-2xl bg-amber-50 border-2 border-amber-400 space-y-3 shadow-md animate-pulse">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-amber-500 text-white font-black text-xs flex items-center justify-center">2</div>
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-200 text-amber-900 text-[10px] font-black uppercase tracking-wider">قيد المعالجة</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-amber-900 leading-tight">② التدقيق والفرز الإداري</h4>
                            <p class="text-[11px] text-amber-800 font-bold mt-1 leading-snug">جاري التحقق الإداري والولائي من الوثائق والسن.</p>
                        </div>
                    </div>
                @else
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-emerald-500/10 via-emerald-50/40 to-white border border-emerald-300 space-y-3 shadow-xs">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-emerald-400 text-white font-black text-xs flex items-center justify-center shadow-md shadow-emerald-500/20"><x-ws.icon name="check" class="w-4 h-4 text-white" /></div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-wider">مكتمل</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-900 leading-tight">② التدقيق والفرز الإداري</h4>
                            <p class="text-[11px] text-slate-600 font-medium mt-1 leading-snug">تم التثبت الإداري والقبول بالمسابقة.</p>
                        </div>
                    </div>
                @endif

                <!-- Step 3: Accreditation & Sizes -->
                @if(in_array($statusKey, ['QUALIFIED_REGIONAL', 'QUALIFIED_NATIONAL']))
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-emerald-500/10 via-emerald-50/40 to-white border border-emerald-300 space-y-3 shadow-xs">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-emerald-400 text-white font-black text-xs flex items-center justify-center shadow-md"><x-ws.icon name="check" class="w-4 h-4 text-white" /></div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-wider">مكتمل</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-900 leading-tight">③ الاعتماد وتأكيد المقاسات</h4>
                            <p class="text-[11px] text-slate-600 font-medium mt-1 leading-snug">تأكيد قياسات البدلة الرسمية والتجهيزات.</p>
                        </div>
                    </div>
                @elseif($statusKey === 'APPROVED')
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-blue-500/15 via-blue-50/60 to-white border-2 border-[#0066FF] space-y-3 shadow-xl shadow-blue-500/15 relative overflow-hidden transform scale-[1.02]">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-[#0066FF] to-[#00B8FF] text-white font-black text-xs flex items-center justify-center shadow-md animate-pulse">3</div>
                            <span class="px-2.5 py-0.5 rounded-full bg-[#0066FF] text-white text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                <span>المرحلة الحالية</span>
                            </span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-[#06205C] leading-tight">③ الاعتماد وتأكيد المقاسات</h4>
                            <p class="text-[11px] text-slate-700 font-bold mt-1 leading-snug">تأكيد قياسات بدلة العمل وتجهيزات السلامة.</p>
                        </div>
                    </div>
                @else
                    <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200/80 space-y-3 opacity-60">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-600 font-black text-xs flex items-center justify-center">3</div>
                            <span class="px-2 py-0.5 rounded-full bg-slate-200/70 text-slate-800 text-[10px] font-bold">موقوفة</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-700 leading-tight">③ الاعتماد وتأكيد المقاسات</h4>
                            <p class="text-[11px] text-slate-800 font-medium mt-1 leading-snug">توفير بدلة العمل وقياس التجهيزات.</p>
                        </div>
                    </div>
                @endif

                <!-- Step 4: Field Competition -->
                @if($statusKey === 'QUALIFIED_NATIONAL')
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-emerald-500/10 via-emerald-50/40 to-white border border-emerald-300 space-y-3 shadow-xs">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-emerald-400 text-white font-black text-xs flex items-center justify-center shadow-md"><x-ws.icon name="check" class="w-4 h-4 text-white" /></div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-wider">مكتمل</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-900 leading-tight">④ خوض المنافسات والمرحلة</h4>
                            <p class="text-[11px] text-slate-600 font-medium mt-1 leading-snug">اجتياز الاختبارات الجهوية بنجاح.</p>
                        </div>
                    </div>
                @elseif($statusKey === 'QUALIFIED_REGIONAL')
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-blue-500/15 via-blue-50/60 to-white border-2 border-[#0066FF] space-y-3 shadow-xl shadow-blue-500/15 relative overflow-hidden transform scale-[1.02]">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-[#0066FF] to-[#00B8FF] text-white font-black text-xs flex items-center justify-center shadow-md animate-pulse">4</div>
                            <span class="px-2.5 py-0.5 rounded-full bg-[#0066FF] text-white text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                <span>المرحلة الحالية</span>
                            </span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-[#06205C] leading-tight">④ خوض المنافسة الجهوية</h4>
                            <p class="text-[11px] text-slate-700 font-bold mt-1 leading-snug">إجراء الاختبارات الميدانية وتقييم الخبراء.</p>
                        </div>
                    </div>
                @else
                    <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200/80 space-y-3 opacity-60">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-600 font-black text-xs flex items-center justify-center">4</div>
                            <span class="px-2 py-0.5 rounded-full bg-slate-200/70 text-slate-800 text-[10px] font-bold">قادمة</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-700 leading-tight">④ خوض المنافسات والمرحلة</h4>
                            <p class="text-[11px] text-slate-800 font-medium mt-1 leading-snug">إجراء الاختبارات الميدانية والتقييم.</p>
                        </div>
                    </div>
                @endif

                <!-- Step 5: Final Awards & Certification -->
                @if($statusKey === 'QUALIFIED_NATIONAL')
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-amber-500/15 via-amber-50/60 to-white border-2 border-amber-500 space-y-3 shadow-xl shadow-amber-500/15 relative overflow-hidden transform scale-[1.02]">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-amber-500 to-amber-400 text-white font-black text-xs flex items-center justify-center shadow-md animate-pulse">5</div>
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500 text-white text-[10px] font-black uppercase tracking-wider flex items-center gap-1">
                                 النهائيات
                            </span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-amber-900 leading-tight">⑤ التتويج والشهادات الوطنية</h4>
                            <p class="text-[11px] text-amber-800 font-bold mt-1 leading-snug">النهائيات الوطنية وتوزيع الشهادات والميداليات.</p>
                        </div>
                    </div>
                @else
                    <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200/80 space-y-3 opacity-60">
                        <div class="flex items-center justify-between">
                            <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-600 font-black text-xs flex items-center justify-center">5</div>
                            <span class="px-2 py-0.5 rounded-full bg-slate-200/70 text-slate-800 text-[10px] font-bold">قادمة</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-700 leading-tight">⑤ التتويج والشهادات</h4>
                            <p class="text-[11px] text-slate-800 font-medium mt-1 leading-snug">إعلان النتائج النهائية وتوزيع الشهادات.</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- ══ Comprehensive Competitor Information Cards Grid ══ -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Card 1: Personal & Identity Information -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4 hover:border-blue-400 transition group">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0066FF] font-black">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-[#06205C]">الهوية الوطنية والمعلومات الشخصية</h3>
                        <span class="text-[10px] text-slate-700 font-bold block">بيانات الحالة المدنية للمترشح</span>
                    </div>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-blue-50 text-[#0066FF] text-[10px] font-black">محققة </span>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-800 font-bold">الاسم الكامل (بالعربية):</span>
                    <strong class="text-[#041235] font-black">{{ $candidateName }}</strong>
                </div>

                @if(!empty($nameFr))
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-800 font-bold">الاسم واللقب (باللاتينية):</span>
                        <strong class="text-[#041235] font-mono font-bold uppercase">{{ $nameFr }}</strong>
                    </div>
                @endif

                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-800 font-bold">الرقم التعريفي الوطني (NIN):</span>
                    <strong class="text-[#0066FF] font-mono font-black tracking-wide">{{ $ninNumber }}</strong>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-700 font-bold text-[10px] block">تاريخ الميلاد:</span>
                        <strong class="text-[#041235] font-mono font-bold">{{ $dob }}</strong>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-700 font-bold text-[10px] block">السن الحالي:</span>
                        <strong class="text-[#041235] font-bold">{{ $age ? ($age . ' سنة') : 'غير محدد' }}</strong>
                    </div>
                </div>

                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-800 font-bold">رقم الهاتف والاتصال:</span>
                    <strong class="text-[#041235] font-mono font-bold dir-ltr">{{ $phoneNum }}</strong>
                </div>

                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-800 font-bold">البريد الإلكتروني:</span>
                    <strong class="text-[#041235] font-mono font-bold truncate max-w-[160px]">{{ $emailAddr }}</strong>
                </div>
            </div>
        </div>

        <!-- Card 2: Educational Institution & Geography -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4 hover:border-emerald-400 transition group">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-black">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0V11m0 10V11"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-[#06205C]">المؤسسة التكوينية والولائية</h3>
                        <span class="text-[10px] text-slate-700 font-bold block">الانتساب التكويني والإقليمي</span>
                    </div>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black">معتمد ️</span>
            </div>

            <div class="space-y-3 text-xs">
                <div class="p-3 rounded-xl bg-emerald-50/50 border border-emerald-100 space-y-1">
                    <span class="text-slate-800 font-bold text-[10px] block">الولاية التكوينية المنتسب إليها:</span>
                    <strong class="text-[#06205C] font-black text-sm block">ولاية {{ $wilayaName }}</strong>
                </div>

                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                    <span class="text-slate-800 font-bold text-[10px] block">المؤسسة التكوينية الرسمية (CFPA/INSFP):</span>
                    <strong class="text-[#041235] font-black text-xs leading-relaxed block">{{ $orgName }}</strong>
                </div>

                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                    <span class="text-slate-800 font-bold text-[10px] block">التخصص والمهارة التنافسية المسندة:</span>
                    <strong class="text-[#0066FF] font-black text-xs block">{{ $reg?->skill?->getLocalized('name') ?? 'التخصص التنافسي الموحد' }}</strong>
                    <span class="text-[10px] font-mono text-slate-700 block pt-0.5">رمز المهارة: {{ $reg?->skill?->code ?? 'SKILL-DZ' }}</span>
                </div>

                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-800 font-bold">الدولة والوفد المشارك:</span>
                    <strong class="text-[#041235] font-black">الجمهورية الجزائرية (DZ) </strong>
                </div>
            </div>
        </div>

        <!-- Card 3: Olympic Qualification Status & Rank -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4 hover:border-amber-400 transition group">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 font-black">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-[#06205C]">صفة ومستوى التأهل الأولمبي</h3>
                        <span class="text-[10px] text-slate-700 font-bold block">الترتيب والمستوى التنافسي الرسمي</span>
                    </div>
                </div>
                <span class="px-2 py-0.5 rounded-full border text-[10px] font-black {{ $statusBadgeClass }}">
                    {{ app()->getLocale() === 'fr' ? $statusLabelFr : $statusLabelAr }}
                </span>
            </div>

            <div class="space-y-3 text-xs">
                <div class="p-3.5 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 space-y-2 text-center">
                    <span class="text-amber-800 font-bold text-[11px] block">درجة التأهل في البطولة الوطنية:</span>
                    <div class="text-base font-black text-amber-900">{{ $statusLabelAr }}</div>
                    @if($statusKey === 'REJECTED')
                        <p class="text-[11px] text-rose-700 font-bold leading-relaxed pt-1">
                            سبب الرفض: {{ $rejectionReason }}
                        </p>
                    @else
                        <p class="text-[10px] text-amber-700 leading-relaxed font-medium">
                            تم اعتماد النتيجة رسمياً من طرف اللجنة الوطنية العليا للتحكيم والتنظيم.
                        </p>
                    @endif
                </div>

                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-800 font-bold">رقم الاعتماد والتوثيق:</span>
                    <strong class="text-[#041235] font-mono font-black">{{ $reg?->registration_number ?? 'WSAP-2026-DZ' }}</strong>
                </div>

                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-800 font-bold">تاريخ التسجيل والاعتماد:</span>
                    <strong class="text-[#041235] font-mono font-bold">{{ $reg?->created_at ? $reg->created_at->format('Y-m-d') : date('Y-m-d') }}</strong>
                </div>
            </div>
        </div>

        <!-- Card 4: Equipment & Uniform Sizes -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4 hover:border-amber-300 transition group relative">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 font-black">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-[#06205C]">قياسات بدلة العمل والتجهيزات</h3>
                        <span class="text-[10px] text-slate-700 font-bold block">تجهيزات السلامة والبدلة الرسمية</span>
                    </div>
                </div>
                @if($isEligibleForBadge)
                    <button type="button" wire:click="$set('showSizeModal', true)" class="px-2.5 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-[11px] font-black transition flex items-center gap-1 shadow-xs">
                        <x-ws.icon name="pencil" class="w-3.5 h-3.5 inline-block me-1 text-amber-600" />
                        <span>تعديل المقاسات</span>
                    </button>
                @endif
            </div>

            <div class="grid grid-cols-3 gap-3 pt-1">
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-1">
                    <span class="text-[10px] font-bold text-slate-700 block">بدلة العمل</span>
                    <strong class="text-base font-black text-[#0066FF] block">{{ $suitSize }}</strong>
                </div>
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-1">
                    <span class="text-[10px] font-bold text-slate-700 block">حذاء السلامة</span>
                    <strong class="text-base font-black text-[#0066FF] block">{{ $shoeSize }}</strong>
                </div>
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-1">
                    <span class="text-[10px] font-bold text-slate-700 block">الطول (سم)</span>
                    <strong class="text-base font-black text-[#0066FF] block">{{ $heightCm }} سم</strong>
                </div>
            </div>

            <p class="text-[11px] text-slate-800 font-medium leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                يتم استخدام هذه المقاسات لتزويد المتنافس بالبدلة الرسمية وحذاء الوقاية الميداني أثناء تحضيرات واختبارات الأولمبياد.
            </p>
        </div>

        <!-- Card 5: Accommodation & Logistics -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4 hover:border-purple-300 transition group">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 font-black">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-[#06205C]">الإقامة والإطعام والنقل</h3>
                        <span class="text-[10px] text-slate-700 font-bold block">اللوجستيك ومقرات الإقامة الأولمبية</span>
                    </div>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 text-[10px] font-black">مخصص </span>
            </div>

            <div class="space-y-3 text-xs">
                <div class="p-3 rounded-xl bg-purple-50/50 border border-purple-100 space-y-1">
                    <span class="text-slate-800 font-bold text-[10px] block">مقر الإقامة والمبيت:</span>
                    <strong class="text-purple-950 font-black text-xs block">
                        {{ $accommodation?->room?->accommodation?->name_ar ?? 'فندق وإقامة أولمبياد المهن الرسمية — الجزائر العاصمة' }}
                    </strong>
                </div>

                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-800 font-bold">الجناح والغرفة المخصصة:</span>
                    <strong class="text-[#041235] font-mono font-black">
                        @if($accommodation?->room)
                            {{ $accommodation->room->building ? ('بلوك ' . $accommodation->room->building . ' — ') : '' }}غرفة {{ $accommodation->room->room_number }}
                        @else
                            جاري التوزيع والتخصيص
                        @endif
                    </strong>
                </div>

                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-800 font-bold">بطاقة الوجبات والإطعام:</span>
                    <strong class="{{ $isEligibleForBadge ? 'text-emerald-700' : 'text-slate-700' }} font-black">
                        {{ $isEligibleForBadge ? 'مفعلة بالمسح الإلكتروني ️' : 'غير متاحة' }}
                    </strong>
                </div>
            </div>
        </div>

        <!-- Card 6: Digital Pass & Security QR Code -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200/80 space-y-4 hover:border-emerald-300 transition group flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-black">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-[#06205C]">شفرة التوثيق والاعتماد QR</h3>
                            <span class="text-[10px] text-slate-700 font-bold block">الرمز الرقمي الموحد للتأكد والمسح</span>
                        </div>
                    </div>
                    @if($isEligibleForBadge)
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black">معتمد </span>
                    @else
                        <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-black">غير معتمد </span>
                    @endif
                </div>

                @if($isEligibleForBadge)
                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 flex items-center gap-4">
                        @php
                            $qrTargetUrl = $reg 
                                ? route('verify', ['token' => $reg->verification_token ?? $reg->registration_number])
                                : route('home');
                        @endphp
                        <div class="w-20 h-20 bg-white p-1 rounded-xl border border-slate-300 shrink-0 shadow-xs">
                            <img src="{{ \App\Services\QrCodeService::generateDataUri($qrTargetUrl, 160) }}" alt="QR Pass Code" class="w-full h-full object-contain">
                        </div>
                        <div class="space-y-1 text-xs">
                            <span class="text-[#0066FF] font-black block">شفرة الاعتماد السريع QR</span>
                            <p class="text-[10px] text-slate-800 font-medium leading-tight">
                                يتيح للهيئات المنظمة الاستقبال والمسح الفوري بالهاتف الذكي للتأكد من هوية المتنافس وتأهله.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold space-y-1">
                        <span class="block font-black">الشفرة البطاقة الرقمية غبر مفعلة</span>
                        <p class="text-[10px] text-rose-700 font-medium">لا يتم إصدار شارة الاعتماد للملفات المرفوضة أو غير المقبولة إدارياً.</p>
                    </div>
                @endif
            </div>

            <div class="pt-2">
                @if($isEligibleForBadge)
                    <button type="button" @click="showBadgeModal = true" class="w-full py-3 rounded-2xl bg-[#06205C] hover:bg-[#0052CC] text-white font-bold text-xs transition shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>عرض وحفظ بطاقة الاعتماد والشهادة الرسمية</span>
                    </button>
                @else
                    <button type="button" disabled class="w-full py-3 rounded-2xl bg-slate-200 text-slate-800 font-bold text-xs cursor-not-allowed flex items-center justify-center gap-2">
                        <span>بطاقة الاعتماد والشهادة غير متاحة</span>
                    </button>
                @endif
            </div>
        </div>

    </div>

    <!-- ══ ACCREDITATION BADGE & QR PASS MODAL (Only Eligible Candidates) ══ -->
    @if($isEligibleForBadge)
        <div x-show="showBadgeModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md" x-cloak>
            <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-6 shadow-2xl border border-slate-200 text-center relative overflow-hidden" @click.away="showBadgeModal = false">
                
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <h3 class="text-sm font-black text-[#06205C]">
                            بطاقة الاعتماد الأولمبية المباشرة
                        </h3>
                    </div>
                    <button @click="showBadgeModal = false" class="text-slate-700 hover:text-slate-600 font-bold text-sm"><x-ws.icon name="x-mark" class="w-4 h-4" /></button>
                </div>

                <!-- Official Badge Card Display -->
                <div class="bg-white rounded-3xl p-6 text-[#041235] space-y-4 shadow-xl border-2 border-slate-200 relative">
                    
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <span class="px-3.5 py-1 rounded-full bg-[#0052CC] text-white text-[10px] font-black tracking-widest uppercase shadow-xs">
                            WORLDSKILLS ALGERIA
                        </span>
                        <span class="text-xs font-mono font-black text-[#041235]">
                            {{ $reg?->registration_number ?? 'WSAP-2026-DZ' }}
                        </span>
                    </div>

                    <!-- Competitor Photo & Name -->
                    <div class="flex flex-col items-center space-y-2">
                        <div class="w-24 h-24 rounded-2xl border-2 border-[#0052CC] overflow-hidden shadow-md bg-slate-100">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" alt="{{ $candidateName }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-white font-black text-3xl bg-[#041235]">
                                    {{ mb_substr($candidateName ?? 'م', 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <h4 class="text-xl font-black text-[#041235]">{{ $candidateName }}</h4>
                        <span class="text-xs text-[#0052CC] font-black bg-blue-50 px-3 py-1 rounded-lg border border-blue-200">
                            {{ $reg?->skill?->getLocalized('name') ?? 'التخصص التنافسي الموحد' }}
                        </span>
                    </div>

                    <!-- QR Code Representation -->
                    <div class="bg-white p-3 rounded-2xl w-44 h-44 mx-auto flex items-center justify-center border-2 border-[#0052CC]/40 shadow-sm">
                        <img src="{{ \App\Services\QrCodeService::generateDataUri($qrTargetUrl, 220) }}" alt="QR Accreditation Pass Code" class="w-full h-full object-contain">
                    </div>

                    <div class="space-y-1.5 text-center">
                        <p class="text-xs text-[#0052CC] font-black">
                            شفرة التوثيق والاعتماد الأولمبي الرقمي
                        </p>
                        <p class="text-[11px] text-[#041235] font-bold max-w-xs mx-auto leading-relaxed">
                            رمز التوثيق والاعتماد الأولمبي المعتمد — يتيح للجان المنظمة والاستقبال المسح الفوري بالهاتف للتأكد من هوية المتنافس وتأهله.
                        </p>
                        <p class="text-xs text-[#041235] font-mono font-black pt-1">
                            Ref: {{ $reg?->registration_number ?? 'WSAP-2026-DZ' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-3 pt-2">
                    <a href="{{ route('official.certificate', ['identifier' => $reg?->registration_number ?? 'WSAP-2026-DZ']) }}" target="_blank" class="px-5 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs transition shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>فتح وطباعة الشهادة الرسمية ↗</span>
                    </a>
                    <button @click="showBadgeModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- ══ EDIT SIZES MODAL ══ -->
    @if(!empty($showSizeModal) && $isEligibleForBadge)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-6 shadow-2xl border border-slate-200 text-right relative" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-[#06205C]">
                        تعديل وتأكيد مقاسات بدلة العمل والتجهيزات
                    </h3>
                    <button type="button" wire:click="$set('showSizeModal', false)" class="text-slate-700 hover:text-slate-600 font-bold text-sm"><x-ws.icon name="x-mark" class="w-4 h-4" /></button>
                </div>

                <form wire:submit.prevent="updateSizes" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            قياس البدلة الرسمية *
                        </label>
                        <select wire:model="editSuitSize" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL', '3XL'] as $sz)
                                <option value="{{ $sz }}">{{ $sz }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            قياس حذاء السلامة الميداني *
                        </label>
                        <select wire:model="editShoeSize" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                            @foreach(range(36, 48) as $sh)
                                <option value="{{ $sh }}">{{ $sh }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            الطول بالسنتيمتر (سم) *
                        </label>
                        <input type="number" wire:model="editHeightCm" min="140" max="210" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" wire:click="$set('showSizeModal', false)" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">
                            إغلاق
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow-md transition">
                            حفظ وتأكيد المقاسات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>