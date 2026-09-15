<div class="py-8 sm:py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 font-sans" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    
    <!-- HEADER -->
    <div class="text-center space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-[#0052CC] text-xs font-black">
            <svg class="w-4 h-4 text-[#0052CC]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <span>WORLDSKILLS ALGERIA — OFFICIAL VERIFICATION SYSTEM</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#041235] tracking-tight">
            {{ app()->getLocale() === "fr" ? "Vérification Officielle des Badges d'Accréditation" : (app()->getLocale() === 'en' ? 'Official Accreditation Badge Verification' : 'التحقق الرسمي من شارات واعتمادات أولمبياد المهن') }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-600 font-bold max-w-xl mx-auto leading-relaxed">
            {{ app()->getLocale() === 'fr' ? 'Plateforme sécurisée de contrôle en temps réel de l\'identité et de l\'homologation des participants.' : (app()->getLocale() === 'en' ? 'Secure real-time verification of participant identity and official accreditation.' : 'نظام التثبت والتوثيق الرقمي الفوري للتأكد من هوية المشارك، تخصصه الأولمبي، وصحة اعتماده الرسمي في المنصة.') }}
        </p>
    </div>

    <!-- SEARCH BAR -->
    <div class="bg-white rounded-3xl p-4 sm:p-6 shadow-lg border border-slate-200">
        <form wire:submit.prevent="verify" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full relative">
                <input 
                    type="text" 
                    wire:model="query" 
                    placeholder="{{ app()->getLocale() === 'fr' ? 'Entrez le code badge ou numéro de dossier...' : (app()->getLocale() === 'en' ? 'Enter badge code or registration number...' : 'أدخل رمز الشارة، كود التوثيق، أو رقم التسجيل...') }}" 
                    class="w-full ps-11 pe-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-mono font-black text-[#041235] placeholder-slate-400 focus:bg-white focus:border-[#0052CC] focus:ring-2 focus:ring-blue-500/20 transition"
                >
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-[#0052CC]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
            </div>
            <button 
                type="submit" 
                class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-[#0052CC] hover:bg-[#0041a8] text-white font-black text-xs shadow-md transition flex items-center justify-center gap-2 shrink-0 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Vérifier' : (app()->getLocale() === 'en' ? 'Verify Code' : 'فحص كود الاعتماد') }}</span>
            </button>
        </form>
    </div>

    <!-- VERIFICATION RESULT -->
    @if($searched)
        @if($nameAr || $result || $verifiedUser || $delegationMember)
            
            <!-- OFFICIAL VERIFIED DOSSIER (PURE BLACK & ROYAL BLUE TYPOGRAPHY) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border-2 border-slate-200 shadow-2xl space-y-6">
                
                {{-- Status Bar --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-3">
                        <span class="w-4 h-4 rounded-full bg-emerald-500 animate-pulse"></span>
                        <div>
                            <span class="text-[10px] font-black uppercase text-[#0052CC] tracking-widest block">HOMOLOGATION OFFICIELLE VÉRIFIÉE</span>
                            <h2 class="text-sm sm:text-base font-black text-[#041235]">اعتماد رسمي ومقبول 100% في المنصة الوطنية</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3.5 py-1.5 rounded-xl bg-blue-100 text-[#0052CC] font-mono font-black text-xs border border-blue-200">
                            Ref: {{ $badgeCode ?: 'WSAP-2026' }}
                        </span>
                        <span class="px-3 py-1.5 rounded-xl bg-emerald-100 text-emerald-800 font-black text-xs border border-emerald-200 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>نشط ومعتمد</span>
                        </span>
                    </div>
                </div>

                {{-- Person Profile Card --}}
                <div class="flex flex-col sm:flex-row items-center gap-6 p-6 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="w-24 h-24 rounded-2xl border-2 border-[#0052CC] overflow-hidden shadow-md shrink-0 bg-white flex items-center justify-center">
                        @if(!empty($photoUrl))
                            <img src="{{ $photoUrl }}" alt="Photo" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white font-black text-3xl bg-[#041235]">
                                {{ mb_substr($nameAr ?: 'م', 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <div class="text-center sm:text-start space-y-1.5 flex-1">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <span class="px-3 py-1 rounded-lg text-xs font-black bg-[#0052CC] text-white">
                                {{ $roleTitle ?: 'متنافس أولمبي معتمد' }}
                            </span>
                            @if($countryName)
                                <span class="px-2.5 py-1 rounded-lg text-xs font-black bg-slate-200 text-[#041235]">
                                    {{ $countryName }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-2xl sm:text-3xl font-black text-[#041235] tracking-tight">
                            {{ $nameAr }}
                        </h3>
                        <p class="text-xs sm:text-sm font-bold text-[#0052CC] font-mono tracking-wider">
                            {{ $nameLatin }}
                        </p>
                    </div>
                </div>

                <!-- 3 DOSSIER SECTIONS: PERSONAL, SKILL, ACCOMMODATION & LOGISTICS -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    
                    <!-- 1. PERSONAL INFORMATION -->
                    <div class="bg-white p-5 rounded-2xl border-2 border-slate-100 shadow-xs space-y-3">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#0052CC]"></span>
                            <h4 class="font-black text-[#041235] text-xs uppercase">المعلومات الشخصية والاتصال</h4>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <span class="text-slate-500 font-bold block text-[10px]">الاسم الكامل باللاتينية:</span>
                                <span class="font-mono font-black text-[#041235] block">{{ $nameLatin }}</span>
                            </div>
                            @if($verifiedUser?->email)
                                <div>
                                    <span class="text-slate-500 font-bold block text-[10px]">البريد الإلكتروني المعتمد:</span>
                                    <span class="font-mono font-bold text-[#041235] block">{{ $verifiedUser->email }}</span>
                                </div>
                            @endif
                            @if($countryName)
                                <div>
                                    <span class="text-slate-500 font-bold block text-[10px]">الدولة / الوفد:</span>
                                    <span class="font-black text-[#041235] block">{{ $countryName }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- 2. SKILL & DISCIPLINE -->
                    <div class="bg-white p-5 rounded-2xl border-2 border-slate-100 shadow-xs space-y-3">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#0052CC]"></span>
                            <h4 class="font-black text-[#041235] text-xs uppercase">التخصص والمهارة الأولمبية</h4>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <span class="text-slate-500 font-bold block text-[10px]">المهارة التنافسية الرسمية:</span>
                                <span class="font-black text-[#0052CC] block text-xs">{{ $skillTitle ?: 'التخصص التنافسي المعتمد' }}</span>
                            </div>
                            @if($organizationName || $wilayaName)
                                <div>
                                    <span class="text-slate-500 font-bold block text-[10px]">المؤسسة والولاية:</span>
                                    <span class="font-black text-[#041235] block">{{ $wilayaName ? 'ولاية ' . $wilayaName : '' }} {{ $organizationName ? '— ' . $organizationName : '' }}</span>
                                </div>
                            @endif
                            <div>
                                <span class="text-slate-500 font-bold block text-[10px]">الصفة والدور:</span>
                                <span class="font-black text-[#041235] block">{{ $roleTitle }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. ACCOMMODATION & LOGISTICS -->
                    <div class="bg-white p-5 rounded-2xl border-2 border-slate-100 shadow-xs space-y-3">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <h4 class="font-black text-[#041235] text-xs uppercase">المبيت والإقامة واللوجستيك</h4>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <span class="text-slate-500 font-bold block text-[10px]">مقر الإقامة / الفندق:</span>
                                <span class="font-black text-emerald-800 block">
                                    {{ $accommodation?->room?->accommodation?->name_ar ?? 'فندق وإقامة الأولمبياد الرسمية — الجزائر العاصمة' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-slate-500 font-bold block text-[10px]">الغرفة والبلوك المخصص:</span>
                                <span class="font-mono font-black text-[#041235] block">
                                    @if($accommodation?->room)
                                        {{ $accommodation->room->building ? 'بلوك ' . $accommodation->room->building . ' — ' : '' }}غرفة {{ $accommodation->room->room_number }}
                                    @else
                                        جاري التوزيع النهائي
                                    @endif
                                </span>
                            </div>
                            @if($result?->suit_size || $result?->shoe_size)
                                <div>
                                    <span class="text-slate-500 font-bold block text-[10px]">مقاسات البدلة والتجهيزات:</span>
                                    <div class="flex items-center gap-2 mt-1 font-mono font-black text-[#041235]">
                                        <span class="bg-slate-100 px-2 py-0.5 rounded border border-slate-200">بدلة: {{ $result->suit_size ?? 'M' }}</span>
                                        <span class="bg-slate-100 px-2 py-0.5 rounded border border-slate-200">حذاء: {{ $result->shoe_size ?? '40' }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Official Stamp Bar --}}
                <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2 text-[#041235] font-bold">
                        <svg class="w-4 h-4 text-[#0052CC]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>تم توثيق وتأكيد صحة هذه الشارة إلكترونياً عبر الخادم الرسمي لأولمبياد المهن الجزائرية.</span>
                    </div>
                    @if($result?->registration_number)
                        <a href="{{ route('official.certificate', ['identifier' => $result->registration_number]) }}" target="_blank" class="px-4 py-2 rounded-xl bg-[#0052CC] hover:bg-[#0041a8] text-white font-black text-xs transition shadow-xs">
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
