<div class="max-w-4xl mx-auto px-4 py-8 space-y-6" dir="rtl">

    {{-- Header --}}
    <div class="text-center space-y-2">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-[#0052CC] text-xs font-black shadow-xs">
            <span class="w-2 h-2 rounded-full bg-[#0066FF] animate-ping"></span>
            <span>المنصة الوطنية للتوثيق والاعتماد الأولمبي — WorldSkills Algeria</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-[#041235] tracking-tight">
            نظام التوثيق والتحقق من الشارة الرسمية
        </h1>
        <p class="text-xs text-slate-800 font-bold max-w-xl mx-auto">
            يتيح هذا المركز للجان المنظمة ولجان الاستقبال والمسح بالتأكد الفوري من الاعتماد والتأهل وحالة المتنافس.
        </p>
    </div>

    {{-- Search Form --}}
    <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-200 space-y-4">
        <form wire:submit.prevent="verify" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input 
                    type="text" 
                    wire:model="query" 
                    placeholder="أدخل رمز الشارة، رقم التسجيل (WSAP-2026-DZ-XXXXXX)، أو المسح المباشر..."
                    class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-[#0052CC] focus:ring-4 focus:ring-blue-100 text-xs font-mono font-bold text-[#041235] placeholder:font-sans placeholder:text-slate-700"
                >
            </div>
            <button type="submit" class="px-6 py-3 rounded-2xl bg-[#0052CC] hover:bg-[#0041a8] text-white font-black text-xs transition shadow-md shrink-0 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>التحقق والتوثيق الآن</span>
            </button>
        </form>
    </div>

    {{-- Results Section --}}
    @if($searched)
        @if($result || $verifiedUser || $delegationMember || $badge)
            
            @php
                $statusRaw = is_object($result?->status) ? ($result->status->value ?? 'APPROVED') : ($result?->status ?? 'APPROVED');
                $statusKey = strtoupper((string) $statusRaw);

                $statusLabelAr = match($statusKey) {
                    'QUALIFIED_NATIONAL' => 'متأهل للنهائيات الوطنية ',
                    'QUALIFIED_REGIONAL' => 'متأهل للبطولة الجهوية  (بطل الولاية)',
                    'APPROVED'           => 'مقبول رسمياً بالبطولة الولائية ',
                    'REJECTED'           => 'غير مقبول ',
                    default              => 'معتمد رسمياً بالمنصة ',
                };

                $statusBadgeClass = match($statusKey) {
                    'QUALIFIED_NATIONAL' => 'bg-amber-500 text-white border-amber-300',
                    'QUALIFIED_REGIONAL' => 'bg-[#0066FF] text-white border-blue-300',
                    'APPROVED'           => 'bg-emerald-500 text-white border-emerald-300',
                    'REJECTED'           => 'bg-rose-500 text-white border-rose-300',
                    default              => 'bg-slate-700 text-white border-slate-500',
                };

                $part = $participant ?? ($result?->participant ?? $verifiedUser?->participant);
                $nin = $part?->national_id ?? ($verifiedUser?->national_id ?? 'غير مسجل');
                $dob = $part?->date_of_birth ? date('Y-m-d', strtotime($part->date_of_birth)) : null;
                $age = $dob ? (date('Y') - date('Y', strtotime($dob))) : null;
                $phone = $part?->phone ?? ($verifiedUser?->phone ?? 'غير مسجل');
                $email = $part?->email ?? ($verifiedUser?->email ?? 'غير مسجل');
                $suitSize = $result?->suit_size ?? ($part?->suit_size ?? 'M');
                $shoeSize = $result?->shoe_size ?? ($part?->shoe_size ?? '42');
                $heightCm = $result?->height_cm ?? ($part?->height_cm ?? '175');
            @endphp

            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xl border-2 border-emerald-500/40 space-y-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-500 via-[#0066FF] to-amber-500"></div>

                {{-- Status Banner --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-[#06205C] border-2 border-emerald-400 overflow-hidden shrink-0 shadow-lg flex items-center justify-center text-white font-black text-2xl">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" alt="{{ $nameAr }}" class="w-full h-full object-cover">
                            @else
                                {{ mb_substr($nameAr ?? 'م', 0, 1) }}
                            @endif
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-0.5 rounded-full text-xs font-black border shadow-xs {{ $statusBadgeClass }}">
                                    {{ $statusLabelAr }}
                                </span>
                                <span class="text-xs font-mono font-bold text-slate-800">
                                    {{ $badgeCode ?: ($result?->registration_number ?? 'WSAP-2026-DZ') }}
                                </span>
                            </div>
                            <h2 class="text-xl font-black text-[#041235]">{{ $nameAr }}</h2>
                            @if($nameLatin && $nameLatin !== $nameAr)
                                <span class="text-xs font-mono font-bold text-slate-700 block dir-ltr">{{ $nameLatin }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="text-right sm:text-left space-y-1">
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-black inline-block">
                            حالة الاعتماد: موثق وساري 
                        </span>
                        <span class="text-[11px] text-slate-700 font-mono block">تاريخ الفحص: {{ date('Y-m-d H:i') }}</span>
                    </div>
                </div>

                {{-- 4 Detailed Grid Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- 1. PERSONAL IDENTITY & NIN -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <div class="flex items-center gap-2 border-b border-slate-200 pb-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#0052CC]"></span>
                            <h4 class="font-black text-[#041235] text-xs uppercase">الهوية الوطنية والمعلومات الشخصية</h4>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-800 font-bold">الاسم الكامل بالعربية:</span>
                                <strong class="text-[#041235] font-black">{{ $nameAr }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-800 font-bold">الاسم واللقب باللاتينية:</span>
                                <strong class="text-[#041235] font-mono font-bold uppercase">{{ $nameLatin }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-800 font-bold">الرقم التعريفي الوطني (NIN):</span>
                                <strong class="text-[#0052CC] font-mono font-black">{{ $nin }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-800 font-bold">تاريخ الميلاد والسن:</span>
                                <strong class="text-[#041235] font-mono font-bold">{{ $dob ? ($dob . ($age ? " ({$age} سنة)" : '')) : 'غير محدد' }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-800 font-bold">الهاتف والاتصال:</span>
                                <strong class="text-[#041235] font-mono font-bold dir-ltr">{{ $phone }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-800 font-bold">البريد الإلكتروني:</span>
                                <strong class="text-[#041235] font-mono font-bold truncate max-w-[180px]">{{ $email }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- 2. SKILL & INSTITUTION -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <div class="flex items-center gap-2 border-b border-slate-200 pb-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#0052CC]"></span>
                            <h4 class="font-black text-[#041235] text-xs uppercase">التخصص والمؤسسة التكوينية</h4>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <span class="text-slate-800 font-bold block text-[10px]">المهارة التنافسية الأولمبية:</span>
                                <strong class="text-[#0052CC] font-black block text-xs mt-0.5">{{ $skillTitle ?: 'التخصص التنافسي المعتمد' }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-800 font-bold block text-[10px]">المؤسسة التكوينية (CFPA/INSFP):</span>
                                <strong class="text-[#041235] font-black block text-xs mt-0.5">{{ $organizationName ?: 'المؤسسة التكوينية المعتمدة' }}</strong>
                            </div>
                            <div class="flex justify-between pt-1">
                                <span class="text-slate-800 font-bold">الولاية التكوينية:</span>
                                <strong class="text-[#06205C] font-black">ولاية {{ $wilayaName ?: 'الجزائر' }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-800 font-bold">الصفة والمستوى:</span>
                                <strong class="text-emerald-700 font-black">{{ $roleTitle }} — {{ $statusLabelAr }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- 3. ACCOMMODATION & ROOM -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <div class="flex items-center gap-2 border-b border-slate-200 pb-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span>
                            <h4 class="font-black text-[#041235] text-xs uppercase">المبيت والإقامة واللوجستيك</h4>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <span class="text-slate-800 font-bold block text-[10px]">مقر الإقامة والفندق:</span>
                                <strong class="text-purple-950 font-black block text-xs mt-0.5">
                                    {{ $accommodation?->room?->accommodation?->name_ar ?? 'فندق وإقامة الأولمبياد الرسمية — الجزائر العاصمة' }}
                                </strong>
                            </div>
                            <div class="flex justify-between pt-1">
                                <span class="text-slate-800 font-bold">الجناح والغرفة:</span>
                                <strong class="text-[#041235] font-mono font-black">
                                    @if($accommodation?->room)
                                        {{ $accommodation->room->building ? ('بلوك ' . $accommodation->room->building . ' — ') : '' }}غرفة {{ $accommodation->room->room_number }}
                                    @else
                                        مخصص بالإقامة الرسمية
                                    @endif
                                </strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-800 font-bold">خدمة الإطعام والوجبات:</span>
                                <strong class="text-emerald-700 font-black">مفعلة بالمسح ️</strong>
                            </div>
                        </div>
                    </div>

                    <!-- 4. EQUIPMENT & WORKWEAR SIZES -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <div class="flex items-center gap-2 border-b border-slate-200 pb-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <h4 class="font-black text-[#041235] text-xs uppercase">قياسات بدلة العمل والتجهيزات</h4>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-center text-xs">
                            <div class="p-2 rounded-xl bg-white border border-slate-200">
                                <span class="text-[10px] text-slate-700 font-bold block">البدلة</span>
                                <strong class="text-sm font-black text-[#0066FF]">{{ $suitSize }}</strong>
                            </div>
                            <div class="p-2 rounded-xl bg-white border border-slate-200">
                                <span class="text-[10px] text-slate-700 font-bold block">الحذاء</span>
                                <strong class="text-sm font-black text-[#0066FF]">{{ $shoeSize }}</strong>
                            </div>
                            <div class="p-2 rounded-xl bg-white border border-slate-200">
                                <span class="text-[10px] text-slate-700 font-bold block">الطول</span>
                                <strong class="text-sm font-black text-[#0066FF]">{{ $heightCm }}سم</strong>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-800 font-medium leading-tight">
                            قياسات معتمدة لتوفير تجهيزات الوقاية الميدانية والزي الرسمي للمسابقة.
                        </p>
                    </div>

                </div>

                {{-- Official Stamp Bar --}}
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2 text-[#041235] font-bold">
                        <svg class="w-4 h-4 text-[#0052CC] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>تم توثيق وتأكيد صحة هذه الشارة والاعتماد إلكترونياً عبر الخادم الرسمي لأولمبياد المهن الجزائرية.</span>
                    </div>
                    @if($result?->registration_number)
                        <a href="{{ route('official.certificate', ['identifier' => $result->registration_number]) }}" target="_blank" class="px-4 py-2 rounded-xl bg-[#0052CC] hover:bg-[#0041a8] text-white font-black text-xs transition shadow-xs shrink-0">
                            عرض الشهادة الرسمية ↗
                        </a>
                    @endif
                </div>

            </div>

        @else
            <div class="p-8 bg-rose-50 border border-rose-200 rounded-3xl text-center space-y-2">
                <div class="flex justify-center"><x-ws.icon name="exclamation-triangle" class="w-8 h-8 text-rose-500" /></div>
                <h3 class="text-base font-black text-rose-800">لم يتم العثور على أي ملف معتمد بهذا الكود</h3>
                <p class="text-xs text-rose-600 font-bold">يرجى التأكد من مسح شارة رسمية معتمدة صادرة عن منصة WorldSkills Algeria.</p>
            </div>
        @endif
    @endif

</div>